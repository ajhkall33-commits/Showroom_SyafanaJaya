<style>
    /* =========================================================================
       DESIGN SYSTEM & CSS VARIABLES
       ========================================================================= */
    :root {
        --sk-primary: #0284c7;
        --sk-primary-hover: #0369a1;
        --sk-primary-light: #e0f2fe;
        --sk-success: #10b981;
        --sk-success-light: #d1fae5;
        --sk-danger: #ef4444;
        --sk-danger-light: #fee2e2;
        --sk-warning: #f59e0b;
        --sk-warning-light: #fef3c7;
        --sk-dark: #0f172a;
        --sk-gray-50: #f8fafc;
        --sk-gray-100: #f1f5f9;
        --sk-gray-200: #e2e8f0;
        --sk-gray-600: #475569;
        --sk-gray-800: #1e293b;
        --sk-radius: 12px;
        --sk-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
    }

    /* Page Header */
    .sk-page-header {
        background: #ffffff;
        border-radius: var(--sk-radius);
        padding: 20px 24px;
        margin-bottom: 20px;
        box-shadow: var(--sk-shadow);
        border: 1px solid var(--sk-gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }
    .sk-title-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .sk-icon-badge {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.3);
    }
    .sk-title-main {
        font-size: 20px;
        font-weight: 700;
        color: var(--sk-dark);
        margin: 0;
        line-height: 1.2;
    }
    .sk-title-sub {
        font-size: 13px;
        color: var(--sk-gray-600);
        margin: 4px 0 0 0;
    }

    /* Stats Cards */
    .sk-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }
    .sk-stat-card {
        background: #ffffff;
        border-radius: var(--sk-radius);
        padding: 16px 20px;
        border: 1px solid var(--sk-gray-200);
        box-shadow: var(--sk-shadow);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .sk-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }
    .sk-stat-info h3 {
        font-size: 24px;
        font-weight: 800;
        color: var(--sk-dark);
        margin: 0;
        line-height: 1.2;
    }
    .sk-stat-info span {
        font-size: 12px;
        font-weight: 600;
        color: var(--sk-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .sk-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .sk-icon-blue { background: var(--sk-primary-light); color: var(--sk-primary); }
    .sk-icon-green { background: var(--sk-success-light); color: var(--sk-success); }
    .sk-icon-orange { background: var(--sk-warning-light); color: var(--sk-warning); }

    /* Main Container Card */
    .sk-main-card {
        background: #ffffff;
        border-radius: var(--sk-radius);
        border: 1px solid var(--sk-gray-200);
        box-shadow: var(--sk-shadow);
        overflow: hidden;
        margin-bottom: 30px;
    }
    .sk-toolbar {
        padding: 18px 20px;
        border-bottom: 1px solid var(--sk-gray-200);
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .sk-search-wrapper {
        position: relative;
        flex: 1;
        min-width: 240px;
        max-width: 420px;
    }
    .sk-search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }
    .sk-search-input {
        width: 100%;
        height: 42px;
        padding: 8px 14px 8px 38px;
        border-radius: 8px;
        border: 1px solid var(--sk-gray-200);
        font-size: 13px;
        color: var(--sk-dark);
        background: var(--sk-gray-50);
        transition: all 0.2s;
    }
    .sk-search-input:focus {
        background: #ffffff;
        border-color: var(--sk-primary);
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        outline: none;
    }
    .sk-filter-select {
        height: 42px;
        border-radius: 8px;
        border: 1px solid var(--sk-gray-200);
        font-size: 13px;
        color: var(--sk-gray-800);
        padding: 6px 14px;
        background: var(--sk-gray-50);
        min-width: 180px;
        cursor: pointer;
    }

    /* Buttons */
    .btn-sk-add {
        height: 42px;
        padding: 0 20px;
        border-radius: 8px;
        background: var(--sk-primary);
        color: #ffffff !important;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.3);
        transition: all 0.2s;
        text-decoration: none !important;
    }
    .btn-sk-add:hover {
        background: var(--sk-primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.4);
    }
    .btn-sk-edit {
        padding: 6px 14px;
        border-radius: 6px;
        background: var(--sk-primary-light);
        color: var(--sk-primary);
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #bae6fd;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-sk-edit:hover {
        background: var(--sk-primary);
        color: #ffffff;
        border-color: var(--sk-primary);
    }
    .btn-sk-delete {
        padding: 6px 14px;
        border-radius: 6px;
        background: var(--sk-danger-light);
        color: var(--sk-danger);
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #fecaca;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-sk-delete:hover {
        background: var(--sk-danger);
        color: #ffffff;
        border-color: var(--sk-danger);
    }

    /* Badges & Pills */
    .badge-role-tag {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
        letter-spacing: 0.3px;
    }
    .badge-role-sk {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #7dd3fc;
    }
    .badge-role-k3 {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
    }
    .badge-unit-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        background: #f8fafc;
        color: #334155;
        border: 1px solid #e2e8f0;
        margin: 2px;
        line-height: 1.3;
        transition: all 0.15s;
    }
    .badge-unit-pill:hover {
        border-color: var(--sk-primary);
        color: var(--sk-primary);
    }
    .badge-unit-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--sk-primary);
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 12px;
        margin-left: 4px;
    }

    /* Desktop Table Styling */
    .sk-table-container {
        width: 100%;
        overflow-x: auto;
    }
    .sk-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    .sk-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 14px 18px;
        border-bottom: 2px solid var(--sk-gray-200);
        vertical-align: middle;
        white-space: nowrap;
    }
    .sk-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 13px;
        color: var(--sk-dark);
    }
    .sk-table tbody tr:hover {
        background: #f8fafc;
    }

    /* Personil Avatar in List */
    .sk-person-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .sk-avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        text-transform: uppercase;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.2);
    }
    .sk-person-info .name {
        font-weight: 700;
        color: var(--sk-dark);
        margin: 0;
        font-size: 13.5px;
    }
    .sk-person-info .sub {
        font-size: 11.5px;
        color: var(--sk-gray-600);
        margin-top: 2px;
    }

    /* =========================================================================
       RESPONSIVE MOBILE VIEW (ADAPTIVE CARD LIST)
       ========================================================================= */
    .sk-mobile-list {
        display: none; /* hidden on desktop */
        padding: 12px;
        gap: 12px;
        flex-direction: column;
    }
    .sk-mobile-card {
        background: #ffffff;
        border: 1px solid var(--sk-gray-200);
        border-radius: var(--sk-radius);
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .sk-mobile-card:active {
        background: #f8fafc;
    }
    .sk-m-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }
    .sk-m-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }
    .sk-m-units-box {
        background: var(--sk-gray-50);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 12px;
        margin-bottom: 14px;
    }
    .sk-m-units-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .sk-m-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .sk-m-actions .btn-sk-edit,
    .sk-m-actions .btn-sk-delete {
        height: 44px; /* Touch friendly 44px */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border-radius: 8px;
    }

    /* Modal Form Customization */
    .modal-sk-content {
        border-radius: 14px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }
    .modal-sk-header {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #ffffff;
        padding: 18px 24px;
        border-bottom: none;
    }
    .modal-sk-title {
        font-size: 17px;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .modal-sk-header .close {
        color: #ffffff;
        opacity: 0.85;
        font-size: 24px;
        text-shadow: none;
        padding: 16px;
    }
    .modal-sk-body {
        padding: 24px;
        background: #ffffff;
    }
    .modal-sk-footer {
        padding: 16px 24px;
        background: var(--sk-gray-50);
        border-top: 1px solid var(--sk-gray-200);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }
    .form-group-sk {
        margin-bottom: 20px;
    }
    .form-group-sk label {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }
    .form-group-sk .help-text {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 5px;
    }

    /* Fix Select2 inside Bootstrap modal */
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        min-height: 42px !important;
        padding: 4px 8px !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--sk-primary) !important;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15) !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e0f2fe !important;
        border: 1px solid #7dd3fc !important;
        color: #0369a1 !important;
        border-radius: 4px !important;
        padding: 3px 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        margin: 3px 4px 3px 0 !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #0369a1 !important;
        margin-right: 5px !important;
    }
    .select2-dropdown {
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
        z-index: 9999 !important;
    }

    /* Mobile Quick Selection helper */
    .unit-quick-actions {
        display: flex;
        gap: 8px;
        margin-bottom: 8px;
    }
    .btn-quick-pill {
        padding: 3px 10px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 14px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        cursor: pointer;
    }
    .btn-quick-pill:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    /* Empty state */
    .sk-empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #64748b;
    }
    .sk-empty-icon {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 12px;
    }

    /* =========================================================================
       MEDIA QUERIES (HP & TABLET RESPONSIVE BREAKPOINTS)
       ========================================================================= */
    @media (max-width: 767.98px) {
        .sk-page-header {
            padding: 16px;
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        .sk-page-header .btn-sk-add {
            width: 100%;
            justify-content: center;
            height: 46px; /* prominent tap button on mobile */
            font-size: 14px;
        }
        .sk-stats-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .sk-toolbar {
            padding: 14px;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        .sk-search-wrapper {
            max-width: 100%;
            width: 100%;
        }
        .sk-filter-select {
            width: 100%;
        }

        /* HIDE DESKTOP TABLE ON HP */
        .sk-table-container {
            display: none !important;
        }

        /* SHOW ADAPTIVE CARD LIST ON HP */
        .sk-mobile-list {
            display: flex !important;
        }

        /* Modal bottom sheet on mobile */
        .modal-dialog {
            margin: 10px auto;
            max-width: calc(100% - 20px);
        }
        .modal-sk-body {
            padding: 16px;
        }
        .modal-sk-footer {
            flex-direction: column-reverse;
            gap: 8px;
            padding: 14px 16px;
        }
        .modal-sk-footer .btn {
            width: 100%;
            height: 44px;
        }
    }
</style>

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">

                <!-- [ HEADER MODUL ] -->
                <div class="sk-page-header">
                    <div class="sk-title-wrapper">
                        <div class="sk-icon-badge">
                            <i class="feather icon-shield"></i>
                        </div>
                        <div>
                            <h4 class="sk-title-main">Pemetaan Hak Akses Unit (SK / Manager)</h4>
                            <p class="sk-title-sub">Kelola unit kerja binaan untuk Senior Koordinator, Koor-K3, dan penugasan multi-unit lainnya.</p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn-sk-add" onclick="openAddModal()">
                            <i class="feather icon-plus-circle"></i> Tambah Pemetaan Baru
                        </button>
                    </div>
                </div>

                <!-- [ STATS RINGKASAN ] -->
                <div class="sk-stats-grid">
                    <div class="sk-stat-card">
                        <div class="sk-stat-info">
                            <h3 id="statTotalSK"><?= $stats['total_sk_users'] ?? 0 ?></h3>
                            <span>Personil Terdaftar</span>
                        </div>
                        <div class="sk-stat-icon sk-icon-blue">
                            <i class="feather icon-users"></i>
                        </div>
                    </div>
                    <div class="sk-stat-card">
                        <div class="sk-stat-info">
                            <h3 id="statTotalUnits"><?= $stats['total_units_managed'] ?? 0 ?></h3>
                            <span>Unit Kerja Terkelola</span>
                        </div>
                        <div class="sk-stat-icon sk-icon-green">
                            <i class="feather icon-grid"></i>
                        </div>
                    </div>
                    <div class="sk-stat-card">
                        <div class="sk-stat-info">
                            <h3 id="statTotalAssignments"><?= $stats['total_assignments'] ?? 0 ?></h3>
                            <span>Total Penugasan</span>
                        </div>
                        <div class="sk-stat-icon sk-icon-orange">
                            <i class="feather icon-check-circle"></i>
                        </div>
                    </div>
                </div>

                <!-- [ MAIN CARD: TOOLBAR & DAFTAR DATA ] -->
                <div class="sk-main-card">
                    <!-- Toolbar Search & Filter -->
                    <div class="sk-toolbar">
                        <div class="sk-search-wrapper">
                            <i class="feather icon-search sk-search-icon"></i>
                            <input type="text" id="filterSearch" class="sk-search-input" placeholder="Cari nama personil, NIK, role, atau unit..." oninput="filterData()">
                        </div>
                        <div>
                            <select id="filterRole" class="sk-filter-select" onchange="filterData()">
                                <option value="">Semua Role</option>
                                <?php foreach ($roles as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name_role']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- DESKTOP TABLE VIEW (Layar >= 768px) -->
                    <div class="sk-table-container">
                        <table class="sk-table" id="tableSKMappings">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">NO</th>
                                    <th>PERSONIL / SK MANAGER</th>
                                    <th>HAK AKSES ROLE</th>
                                    <th>UNIT BINAAN YANG DIKELOLA</th>
                                    <th style="width: 130px;" class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDataDesktop">
                                <!-- Data di-render via Javascript LoadData() -->
                            </tbody>
                        </table>
                    </div>

                    <!-- MOBILE ADAPTIVE CARD LIST VIEW (Layar < 768px / HP) -->
                    <div class="sk-mobile-list" id="mobileCardsContainer">
                        <!-- Data card HP di-render via Javascript LoadData() -->
                    </div>

                    <!-- Empty State Container -->
                    <div id="emptyState" class="sk-empty-state" style="display: none;">
                        <div class="sk-empty-icon">
                            <i class="feather icon-inbox"></i>
                        </div>
                        <h5>Tidak Ada Data Ditemukan</h5>
                        <p class="text-muted">Silakan sesuaikan kata kunci pencarian atau tambah pemetaan unit baru.</p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL FORM INPUT & EDIT (MULTI-SELECT UNIT)
     ========================================================================= -->
<div class="modal fade" id="modalMapping" tabindex="-1" role="dialog" aria-labelledby="modalMappingTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-sk-content">
            <div class="modal-sk-header">
                <h5 class="modal-sk-title" id="modalMappingTitle">
                    <i class="feather icon-edit-2"></i> Form Pemetaan Unit Binaan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formMapping" onsubmit="return submitFormMapping(event)">
                <div class="modal-sk-body">
                    
                    <!-- Hidden field mode edit -->
                    <input type="hidden" id="formMode" value="add">

                    <!-- Pilihan Role -->
                    <div class="form-group-sk">
                        <label for="inputRole">Hak Akses Role <span class="text-danger">*</span></label>
                        <select name="id_role" id="inputRole" class="form-control" style="width: 100%;" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach ($roles as $r): ?>
                                <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name_role']) ?> (<?= htmlspecialchars($r['name_code'] ?? '-') ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <div class="help-text">Pilih role pengguna (misal: SENIOR KOORDINATOR, KOODINATOR AHLI K3, KOORDINATOR, dll).</div>
                    </div>

                    <!-- Pilihan Personil / User -->
                    <div class="form-group-sk">
                        <label for="inputUser">Personil / Pengguna <span class="text-danger">*</span></label>
                        <select name="id_user" id="inputUser" class="form-control" style="width: 100%;" required>
                            <option value="">-- Pilih Personil --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id'] ?>">
                                    <?= htmlspecialchars($u['nama']) ?> - NIK: <?= htmlspecialchars($u['nik'] ?? '-') ?> [<?= htmlspecialchars($u['jabatan'] ?? 'Umum') ?>]
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="help-text">Pilih nama personil yang akan diberikan wewenang akses multi-unit.</div>
                    </div>

                    <!-- Pilihan Multi-Select Unit Binaan -->
                    <div class="form-group-sk">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label for="inputUnits" class="mb-0">Unit Binaan yang Dikelola <span class="text-danger">*</span></label>
                            <div class="unit-quick-actions">
                                <button type="button" class="btn-quick-pill" onclick="selectAllUnits()"><i class="feather icon-check"></i> Pilih Semua</button>
                                <button type="button" class="btn-quick-pill" onclick="clearAllUnits()"><i class="feather icon-x"></i> Bersihkan</button>
                            </div>
                        </div>
                        <select name="unit_ids[]" id="inputUnits" class="form-control" multiple="multiple" style="width: 100%;" required>
                            <?php foreach ($units as $un): ?>
                                <option value="<?= $un['id_unit'] ?>">
                                    <?= htmlspecialchars($un['name_unit']) ?> <?= !empty($un['kode_unit']) ? '['.htmlspecialchars($un['kode_unit']).']' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="help-text">
                            <i class="feather icon-info text-primary"></i> 
                            Dapat memilih lebih dari satu unit (misal: <em>CLEANING GARDU</em>, <em>TERMINAL 1</em>, dll). Personil akan memiliki wewenang penuh atas unit-unit ini.
                        </div>
                    </div>

                </div>
                <div class="modal-sk-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="feather icon-x"></i> Batal
                    </button>
                    <button type="submit" id="btnSubmitForm" class="btn btn-primary">
                        <i class="feather icon-save"></i> Simpan Pemetaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =========================================================================
     JAVASCRIPT LOGIC (DESKTOP + MOBILE HP RESPONSIVE ENGINE)
     ========================================================================= -->
<script>
    var globalMappingsData = [];
    var baseUrl = "<?= base_url() ?>";

    $(document).ready(function() {
        // Inisialisasi Select2 di Modal dengan dropdownParent agar tidak tertutup modal
        $('#inputRole').select2({
            dropdownParent: $('#modalMapping'),
            placeholder: '-- Pilih Role --',
            allowClear: true,
            width: '100%'
        });

        $('#inputUser').select2({
            dropdownParent: $('#modalMapping'),
            placeholder: '-- Cari & Pilih Personil --',
            allowClear: true,
            width: '100%'
        });

        $('#inputUnits').select2({
            dropdownParent: $('#modalMapping'),
            placeholder: 'Pilih satu atau beberapa unit binaan...',
            width: '100%',
            closeOnSelect: false
        });

        // Load data awal via AJAX
        loadMappingsData();
    });

    /**
     * Ambil data dari server
     */
    function loadMappingsData() {
        $.ajax({
            url: baseUrl + "role_sk_manager/LoadData",
            type: "GET",
            dataType: "json",
            beforeSend: function() {
                $('#tbodyDataDesktop').html('<tr><td colspan="5" class="text-center py-4"><i class="feather icon-loader fa-spin"></i> Memuat data pemetaan unit...</td></tr>');
                $('#mobileCardsContainer').html('<div class="text-center py-4 text-muted"><i class="feather icon-loader fa-spin"></i> Memuat data...</div>');
            },
            success: function(res) {
                if (res.status === 200) {
                    globalMappingsData = res.data || [];
                    
                    // Update stats
                    if (res.stats) {
                        $('#statTotalSK').text(res.stats.total_sk_users || 0);
                        $('#statTotalUnits').text(res.stats.total_units_managed || 0);
                        $('#statTotalAssignments').text(res.stats.total_assignments || 0);
                    }

                    renderData(globalMappingsData);
                } else {
                    notifyError(res.message || "Gagal memuat data");
                }
            },
            error: function(err) {
                console.error("AJAX Load Error:", err);
                $('#tbodyDataDesktop').html('<tr><td colspan="5" class="text-center text-danger py-4">Gagal terhubung ke server. Silakan refresh halaman.</td></tr>');
                $('#mobileCardsContainer').html('<div class="text-center text-danger py-4">Gagal memuat data dari server.</div>');
            }
        });
    }

    /**
     * Render data ke tampilan Desktop Table & Mobile Card List
     */
    function renderData(data) {
        var desktopTbody = $('#tbodyDataDesktop');
        var mobileCards = $('#mobileCardsContainer');
        var emptyState = $('#emptyState');

        desktopTbody.empty();
        mobileCards.empty();

        if (!data || data.length === 0) {
            emptyState.show();
            $('#tableSKMappings').hide();
            return;
        }

        emptyState.hide();
        $('#tableSKMappings').show();

        $.each(data, function(index, item) {
            var no = index + 1;
            var initials = getInitials(item.user_nama);

            // Badge Role class
            var roleBadgeClass = "badge-role-tag";
            if (item.name_role.toLowerCase().indexOf('senior') !== -1) {
                roleBadgeClass += " badge-role-sk";
            } else if (item.name_role.toLowerCase().indexOf('k3') !== -1) {
                roleBadgeClass += " badge-role-k3";
            }

            // Generate list unit pills
            var unitPillsHtml = '';
            $.each(item.units, function(uIdx, unit) {
                unitPillsHtml += '<span class="badge-unit-pill"><i class="feather icon-check-circle text-primary mr-1"></i> ' + escapeHtml(unit.name) + '</span>';
            });

            // 1. DESKTOP ROW HTML
            var trHtml = '' +
                '<tr>' +
                '   <td class="text-center font-weight-bold text-muted">' + no + '</td>' +
                '   <td>' +
                '       <div class="sk-person-cell">' +
                '           <div class="sk-avatar-circle">' + initials + '</div>' +
                '           <div class="sk-person-info">' +
                '               <div class="name">' + escapeHtml(item.user_nama) + '</div>' +
                '               <div class="sub"><i class="feather icon-credit-card"></i> NIK: ' + escapeHtml(item.nik) + ' &bull; ' + escapeHtml(item.jabatan) + '</div>' +
                '           </div>' +
                '       </div>' +
                '   </td>' +
                '   <td>' +
                '       <span class="' + roleBadgeClass + '">' + escapeHtml(item.name_role) + '</span>' +
                '   </td>' +
                '   <td>' +
                '       <div class="d-flex align-items-center flex-wrap">' +
                '           <span class="badge-unit-count mr-2 mb-1">' + item.total_units + ' Unit</span>' +
                '           ' + unitPillsHtml +
                '       </div>' +
                '   </td>' +
                '   <td class="text-center">' +
                '       <div class="d-inline-flex gap-1">' +
                '           <button type="button" class="btn-sk-edit mr-1" onclick="openEditModal(' + item.id_user + ', ' + item.id_role + ')" title="Edit Unit Binaan">' +
                '               <i class="feather icon-edit-2"></i> Edit' +
                '           </button>' +
                '           <button type="button" class="btn-sk-delete" onclick="confirmDeleteMapping(' + item.id_user + ', ' + item.id_role + ', \'' + escapeQuotes(item.user_nama) + '\')" title="Hapus Pemetaan">' +
                '               <i class="feather icon-trash-2"></i>' +
                '           </button>' +
                '       </div>' +
                '   </td>' +
                '</tr>';
            desktopTbody.append(trHtml);

            // 2. MOBILE CARD HTML (HP SPECIFIC)
            var cardHtml = '' +
                '<div class="sk-mobile-card">' +
                '   <div class="sk-m-card-header">' +
                '       <div class="sk-m-profile">' +
                '           <div class="sk-avatar-circle">' + initials + '</div>' +
                '           <div class="sk-person-info">' +
                '               <div class="name">' + escapeHtml(item.user_nama) + '</div>' +
                '               <div class="sub">NIK: ' + escapeHtml(item.nik) + '</div>' +
                '           </div>' +
                '       </div>' +
                '       <div>' +
                '           <span class="' + roleBadgeClass + '">' + escapeHtml(item.name_role) + '</span>' +
                '       </div>' +
                '   </div>' +
                '   <div class="sk-m-units-box">' +
                '       <div class="sk-m-units-label">' +
                '           <span><i class="feather icon-grid text-primary"></i> Unit Binaan</span>' +
                '           <span class="badge badge-pill badge-primary">' + item.total_units + ' Unit</span>' +
                '       </div>' +
                '       <div class="d-flex flex-wrap">' + unitPillsHtml + '</div>' +
                '   </div>' +
                '   <div class="sk-m-actions">' +
                '       <button type="button" class="btn-sk-edit" onclick="openEditModal(' + item.id_user + ', ' + item.id_role + ')">' +
                '           <i class="feather icon-edit-2"></i> Edit Unit' +
                '       </button>' +
                '       <button type="button" class="btn-sk-delete" onclick="confirmDeleteMapping(' + item.id_user + ', ' + item.id_role + ', \'' + escapeQuotes(item.user_nama) + '\')">' +
                '           <i class="feather icon-trash-2"></i> Hapus' +
                '       </button>' +
                '   </div>' +
                '</div>';
            mobileCards.append(cardHtml);
        });
    }

    /**
     * Filter client-side realtime
     */
    function filterData() {
        var query = ($('#filterSearch').val() || '').toLowerCase().trim();
        var selectedRole = $('#filterRole').val();

        var filtered = $.grep(globalMappingsData, function(item) {
            var matchRole = true;
            if (selectedRole !== "" && selectedRole !== null) {
                matchRole = (item.id_role.toString() === selectedRole.toString());
            }

            var matchQuery = true;
            if (query !== "") {
                var searchTarget = (
                    item.user_nama + " " +
                    item.nik + " " +
                    item.jabatan + " " +
                    item.name_role + " " +
                    item.units.map(function(u) { return u.name; }).join(" ")
                ).toLowerCase();

                matchQuery = (searchTarget.indexOf(query) !== -1);
            }

            return matchRole && matchQuery;
        });

        renderData(filtered);
    }

    /**
     * Buka Modal Tambah Baru
     */
    function openAddModal() {
        $('#formMode').val('add');
        $('#modalMappingTitle').html('<i class="feather icon-plus-circle"></i> Tambah Pemetaan Unit Baru');
        $('#btnSubmitForm').html('<i class="feather icon-save"></i> Simpan Pemetaan');
        
        // Reset form & Select2
        $('#inputRole').val('').trigger('change').prop('disabled', false);
        $('#inputUser').val('').trigger('change').prop('disabled', false);
        $('#inputUnits').val(null).trigger('change');

        // Buka modal
        $('#modalMapping').modal('show');
    }

    /**
     * Buka Modal Edit
     */
    function openEditModal(id_user, id_role) {
        $('#formMode').val('edit');
        $('#modalMappingTitle').html('<i class="feather icon-edit-2"></i> Edit Unit Binaan Personil');
        $('#btnSubmitForm').html('<i class="feather icon-check"></i> Perbarui Pemetaan');

        // Isi form role dan user
        $('#inputRole').val(id_role).trigger('change').prop('disabled', true);
        $('#inputUser').val(id_user).trigger('change').prop('disabled', true);
        $('#inputUnits').val(null).trigger('change');

        // Ambil assigned unit_ids dari server
        $.ajax({
            url: baseUrl + "role_sk_manager/GetDetail",
            type: "POST",
            data: { id_user: id_user, id_role: id_role },
            dataType: "json",
            success: function(res) {
                if (res.status === 200 && res.unit_ids) {
                    var unitIdsString = res.unit_ids.map(function(id) { return id.toString(); });
                    $('#inputUnits').val(unitIdsString).trigger('change');
                }
            }
        });

        $('#modalMapping').modal('show');
    }

    /**
     * Submit Form Simpan / Update
     */
    function submitFormMapping(e) {
        e.preventDefault();

        var id_role = $('#inputRole').val();
        var id_user = $('#inputUser').val();
        var unit_ids = $('#inputUnits').val();

        if (!id_role) {
            notifyWarning("Silakan pilih Hak Akses Role terlebih dahulu.");
            return false;
        }
        if (!id_user) {
            notifyWarning("Silakan pilih Personil / User.");
            return false;
        }
        if (!unit_ids || unit_ids.length === 0) {
            notifyWarning("Pilih minimal satu unit binaan yang dikelola.");
            return false;
        }

        var btn = $('#btnSubmitForm');
        var originalText = btn.html();
        btn.prop('disabled', true).html('<i class="feather icon-loader fa-spin"></i> Menyimpan...');

        $.ajax({
            url: baseUrl + "role_sk_manager/SaveData",
            type: "POST",
            data: {
                id_role: id_role,
                id_user: id_user,
                unit_ids: unit_ids
            },
            dataType: "json",
            success: function(res) {
                btn.prop('disabled', false).html(originalText);
                if (res.status === 200) {
                    $('#modalMapping').modal('hide');
                    notifySuccess(res.message);
                    loadMappingsData();
                } else {
                    notifyError(res.message || "Gagal menyimpan data.");
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).html(originalText);
                console.error("Save Error:", xhr.responseText);
                notifyError("Terjadi kesalahan jaringan atau server saat menyimpan.");
            }
        });

        return false;
    }

    /**
     * Hapus Pemetaan
     */
    function confirmDeleteMapping(id_user, id_role, userName) {
        if (typeof cuteAlert !== "undefined") {
            cuteAlert({
                type: "question",
                title: "Konfirmasi Hapus",
                message: "Apakah Anda yakin ingin menonaktifkan semua pemetaan unit untuk " + userName + "?",
                confirmText: "Ya, Hapus",
                cancelText: "Batal"
            }).then(function(e) {
                if (e === "confirm") {
                    executeDeleteMapping(id_user, id_role);
                }
            });
        } else {
            if (confirm("Apakah Anda yakin ingin menonaktifkan pemetaan unit untuk " + userName + "?")) {
                executeDeleteMapping(id_user, id_role);
            }
        }
    }

    function executeDeleteMapping(id_user, id_role) {
        $.ajax({
            url: baseUrl + "role_sk_manager/DeleteData",
            type: "POST",
            data: { id_user: id_user, id_role: id_role },
            dataType: "json",
            success: function(res) {
                if (res.status === 200) {
                    notifySuccess(res.message);
                    loadMappingsData();
                } else {
                    notifyError(res.message || "Gagal menghapus data.");
                }
            },
            error: function() {
                notifyError("Gagal terhubung ke server.");
            }
        });
    }

    /**
     * Quick Select Helper
     */
    function selectAllUnits() {
        var allValues = [];
        $('#inputUnits option').each(function() {
            allValues.push($(this).val());
        });
        $('#inputUnits').val(allValues).trigger('change');
    }

    function clearAllUnits() {
        $('#inputUnits').val(null).trigger('change');
    }

    /**
     * Helper Notifikasi (CuteAlert / Toastr / Alert)
     */
    function notifySuccess(msg) {
        if (typeof cuteToast !== "undefined") {
            cuteToast({ type: "success", message: msg, timer: 3000 });
        } else if (typeof toastr !== "undefined") {
            toastr.success(msg);
        } else {
            alert(msg);
        }
    }

    function notifyError(msg) {
        if (typeof cuteToast !== "undefined") {
            cuteToast({ type: "error", message: msg, timer: 3500 });
        } else if (typeof toastr !== "undefined") {
            toastr.error(msg);
        } else {
            alert(msg);
        }
    }

    function notifyWarning(msg) {
        if (typeof cuteToast !== "undefined") {
            cuteToast({ type: "warning", message: msg, timer: 3500 });
        } else if (typeof toastr !== "undefined") {
            toastr.warning(msg);
        } else {
            alert(msg);
        }
    }

    function getInitials(name) {
        if (!name) return "U";
        var parts = name.trim().split(" ");
        if (parts.length >= 2) {
            return (parts[0][0] + parts[1][0]).toUpperCase();
        }
        return name.substring(0, 2).toUpperCase();
    }

    function escapeHtml(text) {
        if (!text) return "";
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function escapeQuotes(text) {
        if (!text) return "";
        return text.replace(/'/g, "\\'");
    }
</script>
