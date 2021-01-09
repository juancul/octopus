<?php


namespace OTP\Objects;

interface MoITemplate
{
    public function build($wD, $oY, $Tg, $Rn, $P8);
    public function parse($wD, $Tg, $Rn, $P8);
    public function getDefaults($JA);
    public function showPreview();
    public function savePopup();
    public static function instance();
    public function getTemplateKey();
    public function getTemplateEditorId();
}
