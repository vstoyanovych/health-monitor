/**
 * AI Assistant - Floating Chat Widget
 * 
 * Provides a floating button and chat interface for AI assistance
 */

(function($) {
	'use strict';

	class AIAssistant {
		constructor() {
			this.conversationHistory = [];
			this.isOpen = false;
			this.isLoading = false;
			this.init();
		}

	init() {
		// Ensure window is hidden on init
		$('#ai-assistant-window').hide();
		this.isOpen = false;
		
		// HTML is now in the template, no need to inject
		this.attachEventListeners();
		this.loadConversationFromStorage();
	}

	attachEventListeners() {
		const self = this;

		try {
			// Toggle chat window
			$('#ai-assistant-button').off('click').on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				self.toggleWindow();
			});

				// Close button
				$('.ai-btn-close').off('click').on('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					self.closeWindow();
				});

				// Clear conversation
				$('.ai-btn-clear').off('click').on('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					self.clearConversation();
				});

				// Send message on button click
				$('#ai-send-btn').off('click').on('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					self.sendMessage();
				});

				// Send message on Enter (Shift+Enter for new line)
				$('#ai-input').off('keydown').on('keydown', function(e) {
					if (e.key === 'Enter' && !e.shiftKey) {
						e.preventDefault();
						self.sendMessage();
					}
				});

			// Auto-resize textarea
			$('#ai-input').off('input').on('input', function() {
				this.style.height = 'auto';
				this.style.height = Math.min(this.scrollHeight, 120) + 'px';
			});
		} catch (e) {
			// Silent error handling
		}
	}

		toggleWindow() {
			this.isOpen = !this.isOpen;
			const $window = $('#ai-assistant-window');
			
			if (this.isOpen) {
				$window.addClass('ai-open').show();
				$('#ai-input').focus();
				this.scrollToBottom();
			} else {
				$window.removeClass('ai-open').hide();
			}
		}

		closeWindow() {
			this.isOpen = false;
			$('#ai-assistant-window').removeClass('ai-open').hide();
		}

		async sendMessage() {
			const input = $('#ai-input');
			const message = input.val().trim();

			if (!message || this.isLoading) {
				return;
			}

			// Clear input
			input.val('');
			input.css('height', 'auto');

			// Add user message to UI
			this.addMessage('user', message);

			// Add to conversation history
			this.conversationHistory.push({
				role: 'user',
				content: message
			});

		// Show loading state
		this.setLoading(true);

	try {
		const response = await $.ajax({
			url: 'index.php?m=aiassistant&d=ajax_send_message&theonepage=1',
			type: 'POST',
			data: {
				message: message,
				history: JSON.stringify(this.conversationHistory)
			},
			dataType: 'json'
		});

		if (response.success) {
			// Check if this is a custom command with HTML
			if (response.is_command && response.html) {
				this.addMessage('assistant', response.response, response.html);
				// Don't add custom commands to conversation history
				// They are system responses, not conversation
			} else {
				this.addMessage('assistant', response.response);
				// Add to conversation history (only regular chat)
				this.conversationHistory.push({
					role: 'assistant',
					content: response.response
				});
				// Save to localStorage
				this.saveConversationToStorage();
			}
		} else {
			this.addMessage('error', response.error || 'Failed to get response');
		}
	} catch (error) {
		let errorMessage = 'Network error. Please try again.';
		if (error.responseText) {
			try {
				const errorData = JSON.parse(error.responseText);
				errorMessage = errorData.error || errorMessage;
			} catch (e) {
				errorMessage = error.responseText.substring(0, 200);
			}
		}
		
		this.addMessage('error', errorMessage);
	} finally {
		this.setLoading(false);
	}
}

		addMessage(type, content, html = null) {
			const messagesContainer = $('#ai-messages');
			let messageHTML = '';

			if (type === 'user') {
				messageHTML = `
					<div class="ai-message ai-message-user">
						<div class="ai-message-content">
							<p>${this.escapeHtml(content)}</p>
						</div>
					</div>
				`;
			} else if (type === 'assistant') {
				// If HTML provided (custom command), use it
				let contentHTML = html ? html : `<p>${this.formatResponse(content)}</p>`;
				
				messageHTML = `
					<div class="ai-message ai-message-assistant">
						<div class="ai-avatar">🤖</div>
						<div class="ai-message-content">
							${contentHTML}
						</div>
					</div>
				`;
			} else if (type === 'error') {
				messageHTML = `
					<div class="ai-message ai-message-error">
						<div class="ai-message-content">
							<p><strong>Error:</strong> ${this.escapeHtml(content)}</p>
						</div>
					</div>
				`;
			}

			messagesContainer.append(messageHTML);
			this.scrollToBottom();
		}

		setLoading(loading) {
			this.isLoading = loading;
			
			if (loading) {
				$('#ai-send-btn').prop('disabled', true).addClass('loading');
				$('#ai-input').prop('disabled', true);
				
				// Add typing indicator
				const typingHTML = `
					<div class="ai-message ai-message-assistant ai-typing">
						<div class="ai-avatar">🤖</div>
						<div class="ai-message-content">
							<div class="ai-typing-indicator">
								<span></span><span></span><span></span>
							</div>
						</div>
					</div>
				`;
				$('#ai-messages').append(typingHTML);
			} else {
				$('#ai-send-btn').prop('disabled', false).removeClass('loading');
				$('#ai-input').prop('disabled', false).focus();
				$('.ai-typing').remove();
			}

			this.scrollToBottom();
		}

		clearConversation() {
			if (confirm('Are you sure you want to clear the conversation?')) {
				this.conversationHistory = [];
				$('#ai-messages').html(`
					<div class="ai-welcome-message">
						<div class="ai-avatar">🤖</div>
						<div class="ai-message-content">
							<p>Hello! I'm your AI assistant. How can I help you today?</p>
						</div>
					</div>
				`);
				localStorage.removeItem('ai_assistant_conversation');
			}
		}

	saveConversationToStorage() {
		try {
			localStorage.setItem('ai_assistant_conversation', JSON.stringify(this.conversationHistory));
		} catch (e) {
			// Silent error handling
		}
	}

	loadConversationFromStorage() {
		try {
			const saved = localStorage.getItem('ai_assistant_conversation');
			if (saved) {
				this.conversationHistory = JSON.parse(saved);
				
				// Restore messages in UI
				this.conversationHistory.forEach(msg => {
					this.addMessage(msg.role, msg.content);
				});
			}
		} catch (e) {
			// Silent error handling
		}
	}

		scrollToBottom() {
			const messagesContainer = $('#ai-messages');
			messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
		}

		escapeHtml(text) {
			const div = document.createElement('div');
			div.textContent = text;
			return div.innerHTML;
		}

		formatResponse(text) {
			// Convert line breaks to <br>
			text = this.escapeHtml(text);
			text = text.replace(/\n/g, '<br>');
			
			// Convert **bold** to <strong>
			text = text.replace(/\*\*([^\*]+)\*\*/g, '<strong>$1</strong>');
			
			// Convert *italic* to <em>
			text = text.replace(/\*([^\*]+)\*/g, '<em>$1</em>');
			
			// Convert `code` to <code>
			text = text.replace(/`([^`]+)`/g, '<code>$1</code>');
			
			return text;
		}
	}

	// Initialize AI Assistant when document is ready
	// Use try-catch to prevent other page errors from breaking it
	try {
		$(document).ready(function() {
			// Check if the AI assistant elements exist before initializing
			if ($('#ai-assistant-button').length > 0) {
				new AIAssistant();
			}
		});
	} catch (e) {
		// Silent error handling
	}

})(jQuery);

