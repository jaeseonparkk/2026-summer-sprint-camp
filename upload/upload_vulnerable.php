<?php
declare(strict_types=1);

// 기존 취약한 파일 업로드 엔드포인트를 비활성화
// HTTP 410 Gone 응답을 반환하여
// 더 이상 사용할 수 없는 기능임을 명시
http_response_code(410);

// 응답 내용을 일반 텍스트 UTF-8 형식으로 설정
header("Content-Type: text/plain; charset=UTF-8");

// 비활성화 응답이 브라우저나 프록시에 캐시되지 않도록 설정
header("Cache-Control: no-store");

// 추가 코드 실행 없이 즉시 종료
exit("이 업로드 엔드포인트는 비활성화되었습니다.");