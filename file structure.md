barangay-sayog-mis/
│
├── config/
│ ├── setup.php
│ ├── database.php
│ ├── session.php
│ ├── auth.php
│ └── functions.php
│
├── auth/
│ ├── login.php
│ ├── register.php
│ └── logout.php
│
├── includes/
│ ├── nav.php
│ ├── secretary_sidebar.php
│ └── resident_sidebar.php
│
├── secretary/
│ ├── dashboard.php
│ │
│ ├── residents/
│ │ ├── index.php
│ │ └── update.php
│ │
│ ├── registrations/
│ │ ├── index.php
│ │ ├── approve.php
│ │ └── reject.php
│ │
│ ├── requests/
│ │ ├── index.php
│ │ ├── view.php
│ │ ├── approve.php
│ │ ├── reject.php
│ │ ├── release.php
│ │ ├── process_approve.php
│ │ ├── process_reject.php
│ │ └── process_release.php
│ │
│ ├── certificates/
│ │ └── history.php
│ │
│ ├── announcements/
│ │ └── index.php
│ │
│ ├── reports/
│ │ └── index.php
│ │
│ └── activity_logs/
│ └── index.php
│
├── resident/
│ ├── dashboard.php
│ ├── documents/
│ │ └── request.php
│ ├── requests/
│ │ └── index.php
│ ├── announcements/
│ │ └── index.php
│ └── profile/
│ └── index.php
│
├── assets/
│ ├── css/
│ │ └── styles.css
│ ├── js/
│ │ └── scripts.js
│ └── uploads/
│
└── database/
└── barangay_sayog_mis.sql


secretary/
└── certificates/
    │
    ├── history.php
    │   → Lists all issued certificates (admin tracking only)
    │
    ├── release.php
    │   → Approves request + triggers certificate generation + saves file_path
    │
    ├── generate_pdf.php
    │   → Core PDF engine (creates certificate file and returns file path)
    │
    ├── view.php
    │   → Admin-only preview of certificate data (no printing, no download control)
    │
    └── templates/
        │
        ├── barangay_clearance.php
        │   → HTML layout for Barangay Clearance PDF
        │
        ├── certificate_of_indigency.php
        │   → HTML layout for Indigency PDF
        │
        └── cedula.php
            → HTML layout for Cedula PDF


resident/
└── requests/
    │
    ├── index.php
    │   → Main tracker of all document requests + download button (if approved)
    │
    ├── download.php
    │   → Secure file delivery (validates ownership + status + file existence)


assets/
└── uploads/
    └── certificates/
        │
        ├── 2024/
        │   → Generated PDFs for 2024
        │
        ├── 2025/
        │   → Generated PDFs for 2025
        │
        ├── 2026/
        │   → Active year storage (current system output)
        │
        └── index.php
            → Security blocker (prevents directory listing)
