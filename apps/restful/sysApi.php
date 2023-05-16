<?php header('Content-Type: Application/json');
date_default_timezone_set('Asia/Tokyo');

class rest {
    function getTimeFormat($param) {
        $return = '';

        if (FALSE) {
        } elseif ( is_int($param) ) {
            if ( $param &  16 ) { $return .= ' ' . date('Y/m/d'); }
            if ( $param &   8 ) { $return .= ' ' . date('H:i:s'); }
            if ( $param &   4 ) { $return .= ' ' . date('T'); }
            if ( $param &   2 ) { $return .= ' ' . date('O'); }
            if ( $param &   1 ) { $return .= ' ' . date('U'); }
        } elseif ( ( ord(mb_substr($param, 0, 1)) >= ord('a') ) && ( ord(mb_substr($param, 0, 1)) <= ord('z') ) ) {
            $return .= ' ' . date(mb_substr($param, 0, 1));
        } elseif ( ( ord(mb_substr($param, 0, 1)) >= ord('A') ) && ( ord(mb_substr($param, 0, 1)) <= ord('Z') ) ) {
            $return .= ' ' . date(mb_substr($param, 0, 1));
        }

        $return = trim($return);
        return $return;
    }
    function getRandomChr($param=0) {
        $return = [];
        if ( $param &   8 ) { array_push( $return, chr( random_int(ord('a'), ord('z')) ) ); }
        if ( $param &   4 ) { array_push( $return, chr( random_int(ord('A'), ord('Z')) ) ); }
        if ( $param &   2 ) { array_push( $return, chr( random_int(ord('0'), ord('9')) ) ); }
        if ( $param &   1 ) { array_push( $return, chr( random_int(ord('!'), ord('/')) ) ); }

        $return = $return[random_int(0, count($return)-1)];
        return $return;
    }
    function getRandomStr($len=5, $type=0) {
        $return = '';
        while (mb_strlen($return)<$len) {
            $return .= $this->getRandomChr($type);
        }
        return $return;
    }
    function getEventUUID() {
        $return = [
            'issued_at' => $this->getTimeFormat(28),
            'generated' => '{year::hash}-{month::hash}-{timestamp::hash}-{timestamp::encode}',
        ];
        $return['generated'] = str_replace('{year::hash}', hash('crc32', $this->getTimeFormat('Y'), false), $return['generated']);
        $return['generated'] = str_replace('{month::hash}', hash('crc32', $this->getTimeFormat('F'), false), $return['generated']);
        $return['generated'] = str_replace('{timestamp::hash}', hash('md5', $this->getTimeFormat('U'), false), $return['generated']);
        $return['generated'] = str_replace('{timestamp::encode}', base64_encode($this->getTimeFormat('U')), $return['generated']);
        return json_encode($return);
        return $this->getRandomStr(8, 14);
    }
}

if (FALSE) {
} elseif (FALSE) {
} elseif ( mb_strtolower( $_SERVER['REQUEST_METHOD'] ) == 'get' ) {
    $rest = new rest();
    if (FALSE) {
    } elseif (FALSE) {
    } elseif ( ! isset( $_REQUEST['act'] ) ) {
    } elseif ( $_REQUEST['act'] == 'uuid.get' ) {
        echo $rest->getEventUUID();
    } elseif ( $_REQUEST['act'] == 'str.random.get' ) {
        $params = [0, 0];
        if ( isset($_REQUEST['chr']) && is_numeric($_REQUEST['chr']) ) {
            $param1 = (int)$_REQUEST['chr'];
        }
        if ( isset($_REQUEST['len']) && is_numeric($_REQUEST['len']) ) {
            $param2 = (int)$_REQUEST['len'];
        }
        echo $rest->getRandomStr($params[0], $params[1]);
    }
    
}
