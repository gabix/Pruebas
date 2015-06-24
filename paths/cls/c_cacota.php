<?php
class c_cacota {

    private $caca = null;
    private $pref_lang = null;

    public function setCaca($v, $pref_lang) {
        $this->caca = $v;
        $this->pref_lang = $pref_lang;
    }

    public function getCaca() {
        return $this->caca;
    }

    public function traerMierdaDelInodoro() {
        if (!isset($inodoro)) {
            return array('err' => true, 'msg' => "l_errMsg-noInodoro");
        } else {
            return array('err' => false, 'msg' => "");
        }
    }

}
