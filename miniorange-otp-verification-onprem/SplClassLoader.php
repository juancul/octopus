<?php


namespace OTP;

if (defined("\101\x42\123\120\101\124\110")) {
    goto PQ;
}
die;
PQ:
final class SplClassLoader
{
    private $_fileExtension = "\56\x70\x68\x70";
    private $_namespace;
    private $_includePath;
    private $_namespaceSeparator = "\x5c";
    public function __construct($il = null, $SU = null)
    {
        $this->_namespace = $il;
        $this->_includePath = $SU;
    }
    public function register()
    {
        spl_autoload_register(array($this, "\x6c\x6f\141\x64\x43\x6c\x61\x73\x73"));
    }
    public function unregister()
    {
        spl_autoload_unregister(array($this, "\154\x6f\141\144\x43\x6c\x61\163\x73"));
    }
    public function loadClass($z_)
    {
        if (!(null === $this->_namespace || $this->isSameNamespace($z_))) {
            goto dd;
        }
        $uj = '';
        $X4 = '';
        if (!(false !== ($ez = strripos($z_, $this->_namespaceSeparator)))) {
            goto GN;
        }
        $X4 = strtolower(substr($z_, 0, $ez));
        $z_ = substr($z_, $ez + 1);
        $uj = str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $X4) . DIRECTORY_SEPARATOR;
        GN:
        $uj .= str_replace("\137", DIRECTORY_SEPARATOR, $z_) . $this->_fileExtension;
        $uj = str_replace("\157\164\160", MOV_NAME, $uj);
        require ($this->_includePath !== null ? $this->_includePath . DIRECTORY_SEPARATOR : '') . $uj;
        dd:
    }
    private function isSameNamespace($z_)
    {
        return $this->_namespace . $this->_namespaceSeparator === substr($z_, 0, strlen($this->_namespace . $this->_namespaceSeparator));
    }
}
