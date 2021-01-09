<?php


namespace OTP\Objects;

abstract class BaseAddOn implements AddOnInterface
{
    function __construct()
    {
        $this->initializeHelpers();
        $this->initializeHandlers();
        add_action("\x6d\157\x5f\157\164\x70\x5f\x76\145\162\x69\x66\x69\x63\x61\164\x69\x6f\156\137\x61\144\x64\137\x6f\156\137\x63\157\156\x74\x72\157\154\x6c\145\x72", array($this, "\163\150\x6f\167\137\x61\144\144\157\x6e\137\x73\145\x74\x74\151\x6e\147\163\137\160\141\x67\145"), 1, 1);
    }
}
