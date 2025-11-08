<?php /* Smarty version 2.6.26, created on 2025-10-27 02:17:40
         compiled from googleads_setup_instructions.tpl */ ?>
<div class="aui-message aui-message-info">
	<p><strong>How to Setup Google AdSense API:</strong></p>
	<ol>
		<li><strong>Go to <a href="https://console.developers.google.com/" target="_blank">Google Cloud Console</a></strong></li>
		<li>Create a new project or select an existing one</li>
		<li>Enable the <strong>AdSense Management API</strong>:
			<ul>
				<li>Go to "APIs & Services" → "Library"</li>
				<li>Search for "AdSense Management API"</li>
				<li>Click "Enable"</li>
			</ul>
		</li>
		<li><strong>Create OAuth 2.0 credentials:</strong>
			<ul>
				<li>Go to "APIs & Services" → "Credentials"</li>
				<li>Click "Create Credentials" → "OAuth client ID"</li>
				<li><strong>IMPORTANT:</strong> If prompted, configure the OAuth consent screen first:
					<ul>
						<li>User Type: "External"</li>
						<li>Fill in App name, User support email, Developer email</li>
						<li>Click "Save and Continue"</li>
						<li>On Scopes, click "Add or Remove Scopes"</li>
						<li>Search for "adsense" and select: <code>https://www.googleapis.com/auth/adsense.readonly</code></li>
						<li>Click "Update" then "Save and Continue"</li>
						<li>Add yourself as a test user</li>
						<li>Click "Save and Continue"</li>
					</ul>
				</li>
				<li>Application type: <strong>"Web application"</strong></li>
				<li>Name it (e.g., "AdSense Dashboard Widget")</li>
				<li>Authorized redirect URIs: Add <code>https://developers.google.com/oauthplayground</code></li>
				<li>Click "Create"</li>
				<li><strong>Copy the Client ID and Client Secret</strong> - save them somewhere safe!</li>
			</ul>
		</li>
		<li><strong>Get your Refresh Token:</strong> ⚠️ <em>MOST IMPORTANT STEP!</em>
			<ul>
				<li>Go to <a href="https://developers.google.com/oauthplayground/" target="_blank">OAuth 2.0 Playground</a></li>
				<li>Click the ⚙️ gear icon (top-right) and check <strong>"Use your own OAuth credentials"</strong></li>
				<li>Enter your <strong>Client ID</strong> and <strong>Client Secret</strong> from step 4</li>
				<li>Close the settings</li>
				<li><strong>⚠️ CRITICAL:</strong> In Step 1, scroll down and find <strong>"AdSense Management API v2"</strong> in the list</li>
				<li><strong>⚠️ MUST CHECK THIS:</strong> <code>https://www.googleapis.com/auth/adsense.readonly</code> (this gives AdSense permission!)</li>
				<li>Click <strong>"Authorize APIs"</strong></li>
				<li><strong>⚠️ IMPORTANT:</strong> Sign in with the <strong>SAME Google account</strong> that has AdSense access</li>
				<li>Click "Allow" to grant permissions (you should see AdSense listed in the permissions)</li>
				<li>In Step 2, click <strong>"Exchange authorization code for tokens"</strong></li>
				<li><strong>Copy the "Refresh token"</strong> - this is what you need!</li>
				<li>⚠️ If you get a 403 error, you need to regenerate the refresh token with the correct scope checked!</li>
			</ul>
		</li>
		<li><strong>Get your AdSense Account ID:</strong>
			<ul>
				<li>Go to <a href="https://www.google.com/adsense/" target="_blank">Google AdSense</a></li>
				<li>Sign in with your account</li>
				<li>Click on "Account" in the left menu</li>
				<li>Look for "Account information"</li>
				<li>Your Publisher ID starts with <code>pub-</code> (e.g., pub-1234567890123456)</li>
				<li><strong>Enter just the pub-XXXXXXXXXXXXXXXX part</strong> (the system will format it correctly)</li>
				<li>Example: <code>pub-3275583773740000</code></li>
			</ul>
		</li>
	</ol>
	<div style="background: #f8d7da; padding: 15px; margin-top: 15px; border-left: 4px solid #dc3545;">
		<p><strong>🚫 403 "Permission Denied" Error Fix:</strong></p>
		<ul>
			<li><strong>Cause:</strong> Your refresh token doesn't have AdSense permissions</li>
			<li><strong>Fix:</strong> Go back to OAuth Playground and generate a NEW refresh token</li>
			<li><strong>CRITICAL:</strong> In Step 1, you MUST check the box for: <code>https://www.googleapis.com/auth/adsense.readonly</code></li>
			<li><strong>Verify:</strong> Make sure you're logged into the Google account that owns the AdSense account</li>
			<li>After authorizing, you should see "AdSense Management" in the list of permissions you're granting</li>
		</ul>
	</div>
	<div style="background: #fff3cd; padding: 15px; margin-top: 15px; border-left: 4px solid #ffc107;">
		<p><strong>⚠️ 401 "Unauthorized Client" Error Fix:</strong></p>
		<ul>
			<li>Make sure you added <code>https://developers.google.com/oauthplayground</code> to Authorized redirect URIs</li>
			<li>Verify the Client ID and Client Secret are copied correctly (no extra spaces)</li>
			<li>Ensure the OAuth consent screen is published or you are added as a test user</li>
			<li>Double-check that you're using the same Google account for AdSense and OAuth</li>
			<li>Wait a few minutes after creating credentials - Google needs time to propagate</li>
		</ul>
	</div>
</div>
