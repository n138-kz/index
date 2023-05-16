<?php header('Content-Type: Application/json');
date_default_timezone_set('Asia/Tokyo');

class rest {
    private $result;
    function __construct() {
        $this->result = [
            'issued_at' => $this->getTimeFormat(28),
            'generated' => [
                'text' => '',
                'blob' => '',
            ],
            'on-error' => FALSE,
        ];
    }
    function getResult() {
        $return = $this->result;
        $return = json_encode($return, JSON_UNESCAPED_SLASHES );
        return $return;
    }
    function setCustomText($param) {
        $this->result['issued_at'] = $this->getTimeFormat(28);
        $return = '';
        $return = trim($param);
        $this->result['generated']['text'] = $return;
        return $return;
    }
    function setErrorStatus($param=NULL) {
        $return = $param;
        if( is_null($return) ) { $return = !!!$this->result['on-error']; }
        return $return;
    }
    function getTimeFormat($param, $timestamp=NULL) {
        $return = '';
        if (is_null($timestamp)) { $timestamp = time(); }
        $this->setErrorStatus(TRUE);
        if ( is_int($param) && $param > 0 ) { $this->setErrorStatus(FALSE); }

        if (FALSE) {
        } elseif ( is_int($param) ) {
            if ( $param &  16 ) { $return .= ' ' . date('Y/m/d', $timestamp); }
            if ( $param &   8 ) { $return .= ' ' . date('H:i:s', $timestamp); }
            if ( $param &   4 ) { $return .= ' ' . date('T', $timestamp); }
            if ( $param &   2 ) { $return .= ' ' . date('O', $timestamp); }
            if ( $param &   1 ) { $return .= ' ' . date('U', $timestamp); }
        } elseif ( ( ord(mb_substr($param, 0, 1)) >= ord('a') ) && ( ord(mb_substr($param, 0, 1)) <= ord('z') ) ) {
            $return .= ' ' . date(mb_substr($param, 0, 1), $timestamp);
        } elseif ( ( ord(mb_substr($param, 0, 1)) >= ord('A') ) && ( ord(mb_substr($param, 0, 1)) <= ord('Z') ) ) {
            $return .= ' ' . date(mb_substr($param, 0, 1), $timestamp);
        }

        $return = trim($return);
        $this->result['generated']['text'] = $return;
        return $return;
    }
    function getRandomChr($param=0) {
        $this->result['issued_at'] = $this->getTimeFormat(28);
        $return = [];
        if ( $param &   8 ) { array_push( $return, chr( random_int(ord('a'), ord('z')) ) ); }
        if ( $param &   4 ) { array_push( $return, chr( random_int(ord('A'), ord('Z')) ) ); }
        if ( $param &   2 ) { array_push( $return, chr( random_int(ord('0'), ord('9')) ) ); }
        if ( $param &   1 ) { array_push( $return, chr( random_int(ord('!'), ord('/')) ) ); }

        if (count($return)>0) {
            $return = $return[random_int(0, count($return)-1)];
        } else {
            $return = '';
        }
        $this->result['generated']['text'] = $return;
        return $return;
    }
    function getRandomStr($len=5, $chr=0) {
        $this->result['issued_at'] = $this->getTimeFormat(28);
        $return = '';
        while (mb_strlen($return)<$len) {
            $return .= $this->getRandomChr($chr);
        }
        $this->result['generated']['text'] = $return;
        return $return;
    }
    function getEventUUID() {
        $this->result['issued_at'] = $this->getTimeFormat(28);
        $return = '{year::hash}-{month::hash}-{timestamp::hash}-{timestamp::encode}';
        $return = str_replace('{year::hash}',        hash('crc32', $this->getTimeFormat('Y'), false), $return);
        $return = str_replace('{month::hash}',       hash('crc32', $this->getTimeFormat('F'), false), $return);
        $return = str_replace('{timestamp::hash}',   hash('md5',   $this->getTimeFormat('U'), false), $return);
        $return = str_replace('{timestamp::encode}', base64_encode($this->getTimeFormat('U')       ), $return);
        $this->result['generated']['text'] = $return;
        return $return;
    }
}

$rest = new rest();
if (FALSE) {
} elseif (FALSE) {
} elseif ( mb_strtolower( $_SERVER['REQUEST_METHOD'] ) == 'get' ) {
    if (FALSE) {
    } elseif (FALSE) {
    } elseif ( ! isset( $_REQUEST['act'] ) ) {
    } elseif ( $_REQUEST['act'] == 'datetime.format.get' ) {
        $params = [
            'format' => 0,
            'datetime' => time(),
        ];
        if ( isset($_REQUEST['format']) && is_numeric($_REQUEST['format']) ) {
            $params['format'] = (int)$_REQUEST['format'];
        }
        if ( isset($_REQUEST['datetime']) ) {
            try {
                $params['datetime'] = (int)strtotime($_REQUEST['datetime']);
            } catch (\Exception $e) {
                error_log($e->getMessage());
                $params['datetime'] = time();
            }
        }
        $rest->setCustomText(
            $rest->getTimeFormat($params['format'], $params['datetime'])
        );
        echo $rest->getResult();
    } elseif ( $_REQUEST['act'] == 'uuid.get' ) {
        $rest->getEventUUID();
        echo $rest->getResult();
    } elseif ( $_REQUEST['act'] == 'str.random.get' ) {
        $params = [
            'chr' => 0,
            'len' => 0,
        ];
        if ( isset($_REQUEST['len']) && is_numeric($_REQUEST['len']) ) {
            $params['len'] = (int)$_REQUEST['len'];
        }
        if ( isset($_REQUEST['chr']) && is_numeric($_REQUEST['chr']) ) {
            $params['chr'] = (int)$_REQUEST['chr'];
        }
        $rest->getRandomStr($params['len'], $params['chr']);
        echo $rest->getResult();
    } elseif ( $_REQUEST['act'] == 'chr.random.get' ) {
        $params = [0];
        if ( isset($_REQUEST['chr']) && is_numeric($_REQUEST['chr']) ) {
            $params[0] = (int)$_REQUEST['chr'];
        }
        $rest->getRandomChr($params[0]);
        echo $rest->getResult();
    } else {
        http_response_code(400);
        exit();
    }
} else {
    http_response_code(405);
    $rest->setCustomText('request method='.mb_strtolower( $_SERVER['REQUEST_METHOD'] ));
    echo $rest->getResult();
    exit();
}
