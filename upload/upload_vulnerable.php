<?php
declare(strict_types=1);

http_response_code(410);
header("Content-Type: text/plain; charset=UTF-8");
header("Cache-Control: no-store");
exit("이 업로드 엔드포인트는 비활성화되었습니다.");
