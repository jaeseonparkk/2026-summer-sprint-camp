# 2026-summer-sprint-camp
```
2026-summer-sprint-camp/
│
├── docker-compose.yml         # Docker Compose 설정
├── Dockerfile                 # PHP 실행 환경 설정
│
├── index.php                  # 메인 페이지
├── login.php                  # 로그인 화면(UI)
├── register.php               # 회원가입 화면(UI)
├── upload.php                 # 파일 업로드 화면(UI)
├── admin.php                  # 관리자 화면(UI)
├── logout.php                 # 로그아웃
│
├── config/
│   └── db.php                 # DB 연결
│
├── db/
│   └── init.sql               # DB 초기화 스크립트
│
├── auth/
│   ├── login_process.php      # 로그인 처리
│   ├── register_process.php   # 회원가입 처리
│   ├── logout_process.php     # 로그아웃 처리
│   └── auth_check.php         # 로그인/권한 확인
│
├── upload/
│   ├── upload_vulnerable.php  # 취약한 파일 업로드 처리
│   ├── upload_secure.php      # 보안 파일 업로드 처리
│   ├── file_list.php          # 업로드 파일 목록 조회
│   └── delete_file.php        # 업로드 파일 삭제
│
├── uploads/                   # 업로드 파일 저장
│
├── css/
│   └── style.css              # 전체 스타일
│
├── js/
│   └── script.js              # 클라이언트 스크립트
│
├── assets/
│   └── images/                # 이미지 리소스
│
└── README.md                  # 프로젝트 설명
