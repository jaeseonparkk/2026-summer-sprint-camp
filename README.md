# 2026-summer-sprint-camp

## 프로젝트 구조

VS Code Explorer의 기본 정렬 방식인 **폴더 우선, 이름 오름차순**을 기준으로 정리했습니다.

```text
2026-summer-sprint-camp/
├── assets/
│   └── images/                # 이미지 리소스
├── auth/
│   ├── admin_action.php       # 관리자 사용자 삭제 처리
│   ├── auth_check.php         # 로그인 및 권한 확인
│   ├── login_process.php      # 로그인 처리
│   ├── logout_process.php     # 로그아웃 처리
│   └── register_process.php   # 회원가입 처리
├── config/
│   └── db.php                 # 데이터베이스 연결 설정
├── css/
│   └── style.css              # 공통 스타일시트
├── db/
│   └── init.sql               # 데이터베이스 초기화 스크립트
├── js/
│   └── script.js              # 업로드 알림 UI 스크립트
├── upload/
│   ├── delete_file.php        # 업로드 파일 삭제
│   ├── file_list.php          # 업로드 파일 목록 조회
│   ├── upload_secure.php      # 보안 파일 업로드 처리
│   └── upload_vulnerable.php  # 비활성화된 기존 엔드포인트(HTTP 410)
├── uploads/
│   └── .gitkeep               # 빈 업로드 디렉터리 유지
├── .gitignore                 # Git 추적 제외 규칙
├── admin.php                  # 관리자 화면
├── docker-compose.yml         # Docker Compose 설정
├── Dockerfile                 # PHP·Apache 실행 환경
├── index.php                  # 메인 페이지
├── login.php                  # 로그인 화면
├── logout.php                 # 로그아웃 안내 화면
├── README.md                  # 프로젝트 설명
├── register.php               # 회원가입 화면
├── secure_coding.php          # 시큐어 코딩 및 프로젝트 안내
└── upload.php                 # 파일 업로드 화면
```

`.git/` 디렉터리는 Git 내부 관리 데이터이므로 구조표에서 제외했습니다.
