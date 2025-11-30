<div class="nuwmhealth-stats">
    <div class="nuwmhealth-stat-card">
        <span class="label">Total pages</span>
        <strong>{$data.total_pages|number_format:0}</strong>
    </div>
    <div class="nuwmhealth-stat-card">
        <span class="label">Ready pages</span>
        <strong class="ready">{$data.ready_pages|number_format:0}</strong>
    </div>
    <div class="nuwmhealth-stat-card">
        <span class="label">Missing content</span>
        <strong class="not-ready">{$data.not_ready_pages|number_format:0}</strong>
    </div>
    <div class="nuwmhealth-stat-card">
        <span class="label">Website readiness</span>
        <strong class="ready">{$data.ready_percent|number_format:1}%</strong>
    </div>
</div>

