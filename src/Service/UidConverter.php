<?php


namespace App\Service;


class UidConverter
{
    /**
     * @var string Chars used for encoding-decoding
     */
    protected $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Encode an integer id to a string uid
     *
     * @param int $in
     * @return string
     */
    public function encode(int $in)
    {
        $out = '';
        $base  = strlen($this->chars);

        for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
            $bcp = bcpow($base, $t);
            $a   = floor($in / $bcp) % $base;
            $out = $out . substr($this->chars, $a, 1);
            $in  = $in - ($a * $bcp);
        }

        return $out;
    }

    /**
     * Decode a string uid to an integer id
     *
     * @param string $in
     * @return int
     */
    public function decode(string $in)
    {
        $out = 0;
        $base  = strlen($this->chars);
        $len = strlen($in) - 1;

        for ($t = $len; $t >= 0; $t--) {
            $bcp = bcpow($base, $len - $t);
            dump([$base, $len - $t, $bcp]);
            $out += intval(strpos($this->chars, substr($in, $t, 1)) * $bcp);
        }

        return $out;
    }
}
