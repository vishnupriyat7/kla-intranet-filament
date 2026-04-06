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
                <div class="chat-tab active" data-tab="Open" onclick="setTab('Open')">Open</div>
                <div class="chat-tab" data-tab="Assigned" onclick="setTab('Assigned')">Assigned</div>
                <div class="chat-tab" data-tab="Resolved" onclick="setTab('Resolved')">Resolved</div>
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
            if (currentTab === 'Assigned') statusMatch = ['Assigned', 'In Progress'].includes(t.status);
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
                    'Resolved': '#388e3c'
                }[t.status] || '#667781';

                // First letter for avatar
                let sectionStr = String(t.section || 'T');
                let letter = sectionStr.length > 0 ? sectionStr.charAt(0).toUpperCase() : 'T';

                let isActive = selectedTicketId === t.id ? 'active' : '';

                // Format date lightly
                let d = new Date(t.created_at || Date.now());
                let timeStr = d.getHours() + ':' + String(d.getMinutes()).padStart(2, '0');

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
                    <small class="text-muted">Requested by ${getEmployeeName(t.employee_id)}</small>
                </div>
            </div>
        `;

        let bodyHtml = `
            <div class="chat-main-body">
                <div class="message-bubble">
                    <strong>Complaint Details</strong>
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

                ${t.status !== 'Open' ? `
                <div class="message-bubble mt-3" style="background-color: #d1f4cc; border: 1px solid #c1e4bc;">
                    <strong>Assignment Details</strong>
                    <p class="mb-0 mt-1">Technician: <b>${techName}</b></p>
                    <p class="mb-0">Status: ${t.status}</p>
                    ${t.remarks ? `<p class="mb-0 mt-2"><b>Remarks:</b> <br/> ${t.remarks}</p>` : ''}
                    <div class="message-info mt-2">${new Date(t.updated_at).toLocaleString()}</div>
                </div>
                ` : ''}
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
        } else if (t.status === 'Assigned' && String(t.technician_id) === String(currentUserId)) {
            footerHtml = `
                    <div class="action-footer">
                        <button class="btn btn-primary px-4" onclick="resolveTicket(${t.id})">
                            ✅ Mark as Resolved
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

    function resolveTicket(id) {
        let remarks = prompt("Enter resolution remarks (optional):");
        if (remarks === null) return; // Cancelled

        fetch(`/helpdesk/resolve-ticket/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
            },
            body: JSON.stringify({ remarks: remarks })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadTickets();
                    alert(data.message);
                } else {
                    alert(data.message || "Failed to resolve ticket.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error occurring while resolving ticket.");
            });
    }

    // Interval to refresh automatically
    setInterval(loadTickets, 5000);
    // Initial fetch
    loadEmployees(); // Load employees in parallel
    loadTickets();   // Load tickets immediately
</script>
@endsection