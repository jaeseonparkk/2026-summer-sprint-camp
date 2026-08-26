2026-summer-sprint-camp-main/
│
├── docker-compose.yml         # Docker 컨테이너 구성
├── Dockerfile                 # PHP + Apache 실행 환경 설정
├── .gitignore                 # Git 추적 제외 설정
├── README.md                  # 프로젝트 설명
│
│   # ── 사용자 화면 ──
├── index.php                  # 메인 페이지
├── login.php                  # 로그인 화면
├── register.php               # 회원가입 화면
├── logout.php                 # 로그아웃
├── upload.php                 # 파일 업로드 화면
├── secure_coding.php          # 시큐어 코딩 소개 및 프로젝트 안내
├── admin.php                  # 관리자 화면
│
│   # ── 데이터베이스 ──
├── config/
│   └── db.php                 # DB 연결 설정
│
├── db/
│   └── init.sql               # DB 및 테이블 초기화
│
│   # ── 인증 및 관리자 처리 ──
├── auth/
│   ├── auth_check.php         # 로그인 및 권한 확인
│   ├── login_process.php      # 로그인 처리
│   ├── register_process.php   # 회원가입 처리
│   ├── logout_process.php     # 로그아웃 처리
│   └── admin_action.php       # 관리자 기능 처리
│
│   # ── 파일 업로드 처리 ──
├── upload/
│   ├── upload_vulnerable.php  # 파일 업로드 처리
│   ├── file_list.php          # 업로드 파일 목록 조회
│   └── delete_file.php        # 업로드 파일 삭제
│
├── uploads/
│   └── .gitkeep               # 업로드 파일 저장 폴더 유지
│
│   # ── 프론트엔드 리소스 ──
├── css/
│   └── style.css              # 전체 스타일
│
└── js/
    └── script.js              # 클라이언트 JavaScript
