@extends('layouts.default')

@section('content')
<style>
    /* WhatsApp UI Styles */
    .whatsapp-container {
        display: flex;
        height: calc(100vh - 100px);
        /* Adjust based on navbar height */
        background-color: #f0f2f5;
        border: 1px solid #d1d7db;
        border-radius: 8px;
        overflow: hidden;
    }

    .chat-sidebar {
        width: 35%;
        background-color: #ffffff;
        border-right: 1px solid #d1d7db;
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        background-color: #f0f2f5;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #d1d7db;
    }

    .chat-search {
        padding: 8px 12px;
        background-color: #ffffff;
        border-bottom: 1px solid #d1d7db;
    }

    .chat-search input,
    .chat-search select {
        width: 100%;
        border-radius: 8px;
        border: none;
        background-color: #f0f2f5;
        padding: 8px 12px;
        outline: none;
        margin-bottom: 8px;
    }

    .chat-tabs {
        display: flex;
        background-color: #ffffff;
        border-bottom: 1px solid #d1d7db;
    }

    .chat-tab {
        flex: 1;
        text-align: center;
        padding: 12px 0;
        cursor: pointer;
        color: #54656f;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: all 0.2s;
    }

    .chat-tab.active {
        color: #00a884;
        border-bottom: 3px solid #00a884;
    }

    .chat-list {
        flex: 1;
        overflow-y: auto;
        background-color: #ffffff;
    }

    .chat-item {
        display: flex;
        padding: 12px 16px;
        border-bottom: 1px solid #f2f2f2;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .chat-item:hover {
        background-color: #f5f6f6;
    }

    .chat-item.active {
        background-color: #f0f2f5;
    }

    .chat-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #dfe5e7;
        margin-right: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #fff;
    }

    .chat-info {
        flex: 1;
        overflow: hidden;
    }

    .chat-title {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
    }

    .chat-name {
        font-weight: 500;
        color: #111b21;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-time {
        font-size: 12px;
        color: #667781;
    }

    .chat-message {
        font-size: 13px;
        color: #667781;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-main {
        width: 65%;
        display: flex;
        flex-direction: column;
        background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
        background-color: #efeae2;
    }

    .chat-main-header {
        background-color: #f0f2f5;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #d1d7db;
    }

    .chat-main-body {
        flex: 1;
        overflow-y: auto;
        padding: 20px 5%;
        display: flex;
        flex-direction: column;
    }

    .message-bubble {
        background-color: #ffffff;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 12px;
        max-width: 80%;
        box-shadow: 0 1px 0.5px rgba(11, 20, 26, .13);
        align-self: flex-start;
    }

    .message-info {
        font-size: 11px;
        color: #667781;
        text-align: right;
        margin-top: 4px;
    }

    .ticket-details table {
        width: 100%;
        font-size: 14px;
    }

    .ticket-details td {
        padding: 4px 0;
    }

    .ticket-details .lbl {
        color: #667781;
        width: 120px;
    }

    .action-footer {
        background-color: #f0f2f5;
        padding: 12px 16px;
        text-align: center;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #667781;
        text-align: center;
    }
</style>

<div class="container-fluid px-3 mt-3 mb-4">
    <div class="whatsapp-container">

        <!-- Left Sidebar: Ticket List -->
        <div class="chat-sidebar">
            <div class="chat-header">
                <strong>🛠️ IT Helpdesk Live</strong>
            </div>

            <div class="chat-tabs">
                <div class="chat-tab active" data-tab="Open" onclick="setTab('Open')">Open <span id="count-Open"
                        class="badge bg-secondary ms-1">0</span></div>
                <div class="chat-tab" data-tab="Assigned" onclick="setTab('Assigned')">Assigned / In Progress <span
                        id="count-Assigned" class="badge bg-secondary ms-1">0</span></div>
                <div class="chat-tab" data-tab="Resolved" onclick="setTab('Resolved')">Resolved <span
                        id="count-Resolved" class="badge bg-secondary ms-1">0</span></div>
            </div>

            <div class="chat-search">
                <div class="row g-2">
                    <div class="col-6">
                        <input type="text" id="filterSearch" placeholder="Search ticket no..." oninput="renderTickets()"
                            class="mb-0">
                    </div>
                    <div class="col-6">
                        <input type="text" id="filterSection" placeholder="Filter Section..." oninput="renderTickets()"
                            class="mb-0">
                    </div>
                </div>
            </div>

            <div class="chat-list" id="ticketList">
                <div class="p-3 text-center text-muted">Loading tickets...</div>
            </div>
        </div>

        <!-- Right Main Panel: Ticket Details -->
        <div class="chat-main" id="ticketDetailPane">
            <div class="empty-state">
                <i class="bi bi-tools" style="font-size: 4rem; color: #aebac1; margin-bottom: 20px;"></i>
                <h4>IT Helpdesk</h4>
                <p>Select a ticket from the left to view details.</p>
            </div>
        </div>

    </div>
</div>

<script>
    let allTickets = [];
    let currentTab = 'Open';
    let selectedTicketId = null;
    const currentUserId = {{ auth() -> id() ?? 'null' }};
    const canTakeTicket = {{ auth() -> check() && in_array(strtolower(auth() -> user() -> role ?? ''), ['chm', 'programmer', 'admin', 'superadmin']) ? 'true' : 'false' }};

    let employeeMap = {};

    function loadEmployees() {
        return fetch('/employees/list')
            .then(res => res.json())
            .then(data => {
                data.forEach(emp => {
                    employeeMap[emp.attendanceId] = emp.name;
                });
            })
            .catch(err => console.error('Error loading employees:', err));
    }

    function loadTickets() {
        fetch('/helpdesk/live-data')
            .then(res => res.json())
            .then(data => {
                allTickets = data;
                updateCounts();
                renderTickets();

                // If a ticket is currently selected, re-render its details
                if (selectedTicketId) {
                    const updatedTicket = allTickets.find(t => t.id === selectedTicketId);
                    if (updatedTicket) {
                        renderTicketDetails(updatedTicket);
                    } else {
                        selectedTicketId = null;
                        clearDetailPane();
                    }
                }
            })
            .catch(err => console.error('Error fetching tickets:', err));
    }

    function updateCounts() {
        const counts = {
            Open: allTickets.filter(t => t.status === 'Open').length,
            Assigned: allTickets.filter(t => ['Assigned', 'In Progress', 'InProgress', 'Pending', 'Complaint'].includes(t.status)).length,
            Resolved: allTickets.filter(t => ['Resolved', 'Closed'].includes(t.status)).length
        };

        document.getElementById('count-Open').innerText = counts.Open;
        document.getElementById('count-Assigned').innerText = counts.Assigned;
        document.getElementById('count-Resolved').innerText = counts.Resolved;
    }

    function getEmployeeName(id) {
        if (!id) return 'Unknown';
        return employeeMap[id] || id; // Return name if in map, otherwise return the ID itself (covers manually typed names)
    }

    function setTab(tabName) {
        currentTab = tabName;
        document.querySelectorAll('.chat-tab').forEach(el => {
            el.classList.remove('active');
            if (el.getAttribute('data-tab') === tabName) {
                el.classList.add('active');
            }
        });
        renderTickets();
    }

    function clearDetailPane() {
        document.getElementById('ticketDetailPane').innerHTML = `
            <div class="empty-state">
                <i class="bi bi-tools" style="font-size: 4rem; color: #aebac1; margin-bottom: 20px;"></i>
                <h4>WhatsApp Web for Helpdesk</h4>
                <p>Select a ticket from the left to view details.</p>
            </div>
        `;
    }

    function renderTickets() {
        const search = document.getElementById('filterSearch').value.toLowerCase();
        const section = document.getElementById('filterSection').value.toLowerCase();

        let filtered = allTickets.filter(t => {
            // Check status array (Done tab can include Resolved and Closed or others)
            let statusMatch = false;
            if (currentTab === 'Open') statusMatch = t.status === 'Open';
            if (currentTab === 'Assigned') statusMatch = ['Assigned', 'In Progress', 'InProgress', 'Pending', 'Complaint'].includes(t.status);
            if (currentTab === 'Resolved') statusMatch = ['Resolved', 'Closed'].includes(t.status);
            if (currentTab === 'All') statusMatch = true;

            let searchMatch = String(t.ticket_no || '').toLowerCase().includes(search) ||
                String(t.employee_id || '').toLowerCase().includes(search);

            let sectionMatch = String(t.section || '').toLowerCase().includes(section);

            return statusMatch && searchMatch && sectionMatch;
        });

        let html = '';
        if (filtered.length === 0) {
            html = `<div class="p-4 text-center text-muted">No tickets found in ${currentTab}.</div>`;
        }

        filtered.forEach(t => {
            try {
                let badgeColor = {
                    'Open': '#f64a4a',
                    'Assigned': '#fbc02d',
                    'In Progress': '#1976d2',
                    'InProgress': '#1976d2',
                    'Pending': '#ff9800',
                    'Complaint': '#e91e63',
                    'Resolved': '#388e3c'
                }[t.status] || '#667781';

                // First letter for avatar
                let sectionStr = String(t.section || 'T');
                let letter = sectionStr.length > 0 ? sectionStr.charAt(0).toUpperCase() : 'T';

                let isActive = selectedTicketId === t.id ? 'active' : '';

                // Format date lightly
                let d = new Date(t.created_at || Date.now());
                let timeStr = d.getHours() + ':' + String(d.getMinutes()).padStart(2, '0');

                let techDisplay = t.technician ? `<div class="chat-message mt-1" style="font-size: 11px; color: #008069; font-weight: 500;"><i class="bi bi-person-gear"></i> ${t.technician.name}</div>` : '';

                html += `
                    <div class="chat-item ${isActive}" onclick="selectTicket(${t.id})">
                        <div class="chat-avatar" style="background-color: ${badgeColor}">${letter}</div>
                        <div class="chat-info">
                            <div class="chat-title">
                                <span class="chat-name">${t.ticket_no || t.id}</span>
                                <span class="chat-time">${timeStr}</span>
                            </div>
                            <div class="chat-message">
                                ${t.section || 'N/A'} • ${t.complaint_type || ''}
                            </div>
                            <div class="chat-message mt-1" style="font-size: 11px; opacity: 0.8;">
                                <i class="bi bi-geo-alt"></i> ${(t.location ? t.location.location : t.office_location_id) || '-'} / ${(t.room ? t.room.name : t.room_id) || '-'}
                            </div>
                            ${techDisplay}
                        </div>
                    </div>
                `;
            } catch (err) {
                console.error("Error rendering ticket:", t, err);
            }
        });

        document.getElementById('ticketList').innerHTML = html;
    }

    function selectTicket(id) {
        selectedTicketId = id;
        renderTickets(); // Re-render to show active state on left side

        const t = allTickets.find(t => t.id === id);
        if (!t) return;
        renderTicketDetails(t);
    }

    function renderTicketDetails(t) {
        let techName = t.technician ? t.technician.name : 'Unassigned';

        let headerHtml = `
            <div class="chat-main-header">
                <div class="chat-avatar" style="background-color: #00a884; margin-right: 15px;">#</div>
                <div>
                    <h6 class="mb-0">${t.ticket_no} <span class="badge bg-secondary ms-2">${t.status}</span></h6>
                    <small class="text-muted">Requested by ${t.section || 'Unknown'} ${t.technician ? ` • <span style="color: #008069; font-weight: 500;">Assigned to: ${t.technician.name}</span>` : ''}</small>
                </div>
            </div>
        `;

        let bodyHtml = `
            <div class="chat-main-body">
                <div class="message-bubble w-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>Complaint Details</strong>
                        <span class="badge bg-light text-dark border">#${t.ticket_no}</span>
                    </div>
                    <div class="ticket-details mt-2">
                        <table>
                            <tr><td class="lbl">Section</td><td>${t.section || '-'}</td></tr>
                            <tr><td class="lbl">Location/Room</td><td>${(t.location ? t.location.location : t.office_location_id) || '-'} / ${t.floor || '-'} / ${(t.room ? t.room.name : t.room_id) || '-'}</td></tr>
                            <tr><td class="lbl">Type</td><td>${t.complaint_type || '-'}</td></tr>
                            <tr><td class="lbl">Description</td><td>${t.description || '-'}</td></tr>
                        </table>
                    </div>
                    <div class="message-info">${new Date(t.created_at).toLocaleString()}</div>
                </div>

                ${(t.status_histories || []).map(h => `
                <div class="message-bubble mt-3 w-100" style="background-color: #d1f4cc; border: 1px solid #c1e4bc;">
                    <div class="d-flex justify-content-between">
                        <strong>Status Update: ${h.status}</strong>
                        <small class="text-muted">${new Date(h.created_at).toLocaleString()}</small>
                    </div>
                    <p class="mb-0 mt-1">Technician: <b>${h.technician ? h.technician.name : 'Unknown'}</b></p>
                    ${h.remarks ? `<p class="mb-0 mt-1"><b>Remarks:</b> <br/> ${h.remarks}</p>` : ''}
                </div>
                `).join('')}
            </div>
        `;

        let footerHtml = '';
        if (t.status === 'Open' && canTakeTicket) {
            footerHtml = `
                <div class="action-footer">
                    <button class="btn btn-success px-4" onclick="takeTicket(${t.id})">
                        🙋 Take Ticket
                    </button>
                </div>
            `;
        } else if (['Assigned', 'In Progress', 'InProgress', 'Pending', 'Complaint'].includes(t.status) && String(t.technician_id) === String(currentUserId)) {
            footerHtml = `
                    <div class="action-footer">
                        <button class="btn btn-primary px-4" onclick="openStatusModal(${t.id})">
                            🔄 Update Status
                        </button>
                    </div>
                `;
        }

        document.getElementById('ticketDetailPane').innerHTML = headerHtml + bodyHtml + footerHtml;
    }

    function takeTicket(id) {
        if (!confirm("Are you sure you want to take this ticket?")) return;

        fetch(`/helpdesk/take-ticket/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
            }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Immediately refresh data
                    loadTickets();
                    alert(data.message);
                } else {
                    alert(data.message || "Failed to assign ticket.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error occurring while assigning ticket.");
            });
    }

    function openStatusModal(id) {
        const t = allTickets.find(t => t.id === id);
        if (!t) return;

        document.getElementById('modalTicketId').value = t.id;
        document.getElementById('modalStatus').value = t.status === 'In Progress' ? 'InProgress' : (['Resolved', 'Pending', 'InProgress', 'Complaint'].includes(t.status) ? t.status : 'InProgress');
        document.getElementById('modalRemarks').value = t.remarks || '';

        var statusModal = new bootstrap.Modal(document.getElementById('statusUpdateModal'));
        statusModal.show();
    }

    function submitStatusUpdate() {
        const id = document.getElementById('modalTicketId').value;
        const status = document.getElementById('modalStatus').value;
        const remarks = document.getElementById('modalRemarks').value;

        fetch(`/helpdesk/resolve-ticket/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
            },
            body: JSON.stringify({
                status: status,
                remarks: remarks
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    var statusModalEl = document.getElementById('statusUpdateModal');
                    var modal = bootstrap.Modal.getInstance(statusModalEl);
                    modal.hide();
                    loadTickets();
                    alert(data.message);
                } else {
                    alert(data.message || "Failed to update status.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error occurring while updating status.");
            });
    }

    function resolveTicket(id) {
        // Keep for legacy if needed or remove
    }

    // Interval to refresh automatically
    setInterval(loadTickets, 5000);
    // Initial fetch
    loadEmployees(); // Load employees in parallel
    loadTickets();   // Load tickets immediately
</script>
<!-- Status Update Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-labelledby="statusUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusUpdateModalLabel">Update Ticket Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modalTicketId">
                <div class="mb-3">
                    <label for="modalStatus" class="form-label">Select Status</label>
                    <select class="form-select" id="modalStatus">
                        <option value="Resolved">Resolved</option>
                        <option value="Pending">Pending</option>
                        <option value="InProgress">InProgress</option>
                        <option value="Complaint">Complaint</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="modalRemarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="modalRemarks" rows="3" placeholder="Enter remarks if any..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitStatusUpdate()">Update Status</button>
            </div>
        </div>
    </div>
</div>
@endsection