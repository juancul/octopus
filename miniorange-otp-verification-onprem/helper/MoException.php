<?php


namespace OTP\Helper;

if (defined("\x41\x42\123\120\101\124\110")) {
    goto FG;
}
die;
FG:
class MoException extends \Exception
{
    private $moCode;
    public function __construct($O_, $Tg, $II)
    {
        $this->moCode = $O_;
        parent::__construct($Tg, $II, NULL);
    }
    public function getMoCode()
    {
        return $this->moCode;
    }
}
