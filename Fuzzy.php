<?php
/**
 * @author Randy Vianda Putra
 * @todo Fuzzy Algorithm
 */

class Fuzzy
{
    protected $memberIPKBuruk = 0;
    protected $memberIPKCukup = 0;
    protected $memberIPKBagus = 0;
    protected $memberGajiKecil = 0;
    protected $memberGajiSedang = 0;
    protected $memberGajiBesar = 0;
    protected $memberGajiSgtBesar = 0;
    protected $memberNKrendah = [];
    protected $memberNKtinggi = [];
    protected $rendah_final;
    protected $tinggi_final;
    protected $max_output = 100;
    protected $min_output = 0;
    protected $crispOutput;

    public function anggotaIPK($inputIPK)
    {
        // mencetak keanggotaan linguisik buruk
        if ($inputIPK <= 2.0) {
            $this->memberIPKBuruk = 1;
        } else {
            if ($inputIPK < 2.75) {
                $this->memberIPKBuruk = ((-$inputIPK + 2.75) / 0.75);
            } else {
                $this->memberIPKBuruk = 0;
            }
        }

        // mencetak keanggotaan linguisik cukup
        if (($inputIPK <= 2.0) || ($inputIPK >= 3.25)) {
            $this->memberIPKCukup = 0;
        } else {
            if ($inputIPK < 2.75) {
                $this->memberIPKCukup = (($inputIPK - 2) / 0.75);
            } else {
                if (($inputIPK > 2.75) && $inputIPK < 3.25) {
                    $this->memberIPKCukup = ((-$inputIPK + 3.25) / 0.5);
                } else {
                    $this->memberIPKCukup = 1;
                }
            }
        }

        // mencetak keanggotaan linguisik bagus
        if ($inputIPK <= 2.75) {
            $this->memberIPKBagus = 0;
        } else {
            if ($inputIPK < 3.25) {
                $this->memberIPKBagus = (($inputIPK - 2.75) / 0.5);
            } else {
                $this->memberIPKBagus = 1;
            }
        }
    }

    public function anggotaGaji($inputGaji)
    {
        // mencetak keanggotaan linguisik buruk
        if ($inputGaji <= 1.0) {
            $this->memberGajiKecil = 1;
        } else {
            if ($inputGaji < 3.0) {
                $this->memberGajiKecil = ((- $inputGaji + 3.0) / 2.0);
            } else {
                $this->memberGajiKecil = 0;
            }
        }

        // mencetak keanggotaan linguisik sedang
        if (($inputGaji >= 3.0) && ($inputGaji <= 4.0)) {
            $this->memberGajiSedang = 1;
        } else {
            if ($inputGaji < 3.0) {
                $this->memberGajiSedang = (($inputGaji - 1.0) / 2.0);
            } else {
                if (($inputGaji > 4.0) && $inputGaji < 6.0) {
                    $this->memberGajiSedang = ((-$inputGaji + 6.0) / 2.0);
                } else {
                    $this->memberGajiSedang = 0;
                }
            }
        }

        // mencetak keanggotaan linguisik besar
        if (($inputGaji > 6.0) && ($inputGaji <= 7.0)) {
            $this->memberGajiBesar = 1;
        } else {
            if (($inputGaji > 4.0) && ($inputGaji < 6.0)) {
                $this->memberGajiBesar = (($inputGaji - 4.0) / 2.0);
            } else {
                if (($inputGaji > 7.0) && ($inputGaji < 12.0)) {
                    $this->memberGajiBesar = ((-$inputGaji + 12.0) / 5.0);
                } else {
                    $this->memberGajiBesar = 0;
                }
            }
        }

        // mencetak keanggotaan linguisik sangat besar
        if ($inputGaji >= 12.0) {
            $this->memberGajiSgtBesar = 1;
        } else {
            if (($inputGaji > 7.0) && $inputGaji < 12.0) {
                $this->memberGajiSgtBesar = (($inputGaji - 7.0) / 5.0);
            } else {
                $this->memberGajiSgtBesar = 0;
            }
        }
    }

    public function cetakMember()
    {
       echo "Keanggotaan IPK :" . "<br>";
       echo "Buruk : " . $this->memberIPKBuruk . "<br>";
       echo "Cukup : " . $this->memberIPKCukup . "<br>";
       echo "Bagus : " . $this->memberIPKBagus . "<br>";
       echo "Keanggotaan Gaji :" . "<br>";
       echo "Kecil : " . $this->memberGajiKecil . "<br>";
       echo "Sedang : " . $this->memberGajiSedang . "<br>";
       echo "Besar : " . $this->memberGajiBesar . "<br>";
       echo "Sangat Besar : " . $this->memberGajiSgtBesar . "<br>";
    }

    public function min($x, $y)
    {
        if ($x < $y) {
            return $x;
        } else {
            return $y;
        }
    }

    public function max($x, $y)
    {
        if ($x > $y) {
            return $x;
        } else {
            return $y;
        }
    }

    public function maxArray($x, $n)
    {
        $max = 0;
        for ($i=0; $i < $n ; $i++) { 
            if ($x[$i] > $max) {
                $max = $x[$i];
            }
        }
        return $max;
    }

    public function inferensi()
    {
        $i = 0; 
        $j = 0;
        if ($this->memberIPKBuruk != 0 && $this->memberGajiKecil != 0) {
            $this->memberNKrendah[$i] = $this->min($this->memberIPKBuruk, $this->memberGajiKecil);
            echo "Rules 1 --> NK Rendah : " . $this->memberNKrendah[$i] . "<br>";
            $i++;
        }
        if ($this->memberIPKBuruk != 0 && $this->memberGajiSedang != 0) {
            $this->memberNKrendah[$i] = $this->min($this->memberIPKBuruk, $this->memberGajiSedang);
            echo "Rules 2 --> NK Rendah : " . $this->memberNKrendah[$i] . "<br>";
            $i++;
        }
        if ($this->memberIPKBuruk != 0 && $this->memberGajiBesar != 0) {
            $this->memberNKrendah[$i] = $this->min($this->memberIPKBuruk, $this->memberGajiBesar);
            echo "Rules 3 --> NK Rendah : " . $this->memberNKrendah[$i] . "<br>";
            $i++;
        }
        if ($this->memberIPKBuruk != 0 && $this->memberGajiSgtBesar != 0) {
            $this->memberNKrendah[$i] = $this->min($this->memberIPKBuruk, $this->memberGajiSgtBesar);
            echo "Rules 4 --> NK Rendah : " . $this->memberNKrendah[$i] . "<br>";
            $i++;
        }
        if ($this->memberIPKCukup != 0 && $this->memberGajiKecil != 0) {
            $this->memberNKtinggi[$i] = $this->min($this->memberIPKCukup, $this->memberGajiKecil);
            echo "Rules 5 --> NK Tinggi : " . $this->memberNKtinggi[$j] . "<br>";
            $j++;
        }
        if ($this->memberIPKCukup != 0 && $this->memberGajiSedang != 0) {
            $this->memberNKrendah[$i] = $this->min($this->memberIPKCukup, $this->memberGajiSedang);
            echo "Rules 6 --> NK Rendah : " . $this->memberNKrendah[$i] . "<br>";
            $i++;
        }
        if ($this->memberIPKCukup != 0 && $this->memberGajiBesar != 0) {
            $this->memberNKrendah[$i] = $this->min($this->memberIPKCukup, $this->memberGajiBesar);
            echo "Rules 7 --> NK Rendah : " . $this->memberNKrendah[$i] . "<br>";
            $i++;
        }
        if ($this->memberIPKCukup != 0 && $this->memberGajiSgtBesar != 0) {
            $this->memberNKrendah[$i] = $this->min($this->memberIPKCukup, $this->memberGajiSgtBesar);
            echo "Rules 8 --> NK Rendah : " . $this->memberNKrendah[$i] . "<br>";
            $i++;
        }
        if ($this->memberIPKBagus != 0 && $this->memberGajiKecil != 0) {
            $this->memberNKtinggi[$j] = $this->min($this->memberIPKBagus, $this->memberGajiKecil);
            echo "Rules 9 --> NK Tinggi : " . $this->memberNKtinggi[$j] . "<br>";
            $j++;
        }
        if ($this->memberIPKBagus != 0 && $this->memberGajiSedang != 0) {
            $this->memberNKtinggi[$j] = $this->min($this->memberIPKBagus, $this->memberGajiSedang);
            echo "Rules 10 --> NK Tinggi : " . $this->memberNKtinggi[$j] . "<br>";
            $j++;
        }
        if ($this->memberIPKBagus != 0 && $this->memberGajiBesar != 0) {
            $this->memberNKtinggi[$j] = $this->min($this->memberIPKBagus, $this->memberGajiBesar);
            echo "Rules 11 --> NK Tinggi : " . $this->memberNKtinggi[$j] . "<br>";
            $j++;
        }
        if ($this->memberIPKBagus != 0 && $this->memberGajiSgtBesar != 0) {
            $this->memberNKrendah[$i] = $this->min($this->memberIPKBagus, $this->memberGajiSgtBesar);
            echo "Rules 12 --> NK Rendah : " . $this->memberNKrendah[$i] . "<br>";
            $i++;
        }

        if ($i == 0) {
            $this->rendah_final = 0;
        } else {
            $this->rendah_final = $this->maxArray($this->memberNKrendah, $i);
        }
        // dump($this->memberNKtinggi);exit;
        if ($j == 0) {
            $this->tinggi_final = 0;
        } else {
            $this->tinggi_final = $this->maxArray($this->memberNKtinggi, $j);
        }

        echo "Hasil Akhir Inferensi : " . "<br>";
        echo "NK rendah : " . $this->rendah_final . "<br>";
        echo "NK tinggi : " . $this->tinggi_final . "<br>";
    }

    public function valNkRendah($x)
    {
        if ($x <= 50) {
            return 1;
        } else {
            if ($x <= 80) {
                return ((-$x + 80) / 30);
            } else {
                return 0;
            }
        }
    }

    public function valNkTinggi($x)
    {
        if ($x <= 50) {
            return 0;
        } else {
            if ($x <= 80) {
                return (($x - 50) / 30);
            } else {
                return 1;
            }
        }
    }

    public function defuzzCentroid($sampel)
    {
        $t = ($this->max_output - $this->min_output) / $sampel;
        $pengali_rendah = $pengali_tinggi = $pengali_others = $others = $pengali = $sampels = [];
        $valRendah = $valTinggi = '';
        $i = 0;
        $sumX = 0;
        $crisp_val = 0;
        $x = $this->min_output;
        $iRendah = $iTinggi = $iOthers = 0;
        for ($i=0; $i < $sampel; $i++) { 
            $x = $x + $t;
            $sampels[$i] = $x;
            $valRendah = $this->valNkRendah($x);
            $valTinggi = $this->valNkTinggi($x);
            if ($valRendah > $this->rendah_final) {
                $valRendah = $this->rendah_final;
            }
            if ($valTinggi > $this->tinggi_final) {
                $valTinggi = $this->tinggi_final;
            }
            $pengali[$i] = $this->max($valRendah, $valTinggi);
            if ($pengali[$i] == $this->rendah_final) {
                $pengali_rendah[$iRendah] = $x;
                $iRendah++;
            } else {
                if ($pengali[$i] == $this->tinggi_final) {
                    $pengali_tinggi[$iTinggi] = $x;
                    $iTinggi++;
                } else {
                    $pengali_others[$iOthers] = $x;
                    $others[$iOthers] = $pengali[$i];
                    $iOthers++;
                }
            }
            $crisp_val = $crisp_val + $x * $pengali[$i];
            $sumX = $sumX + $pengali[$i];
        }

        echo "Crisp val : " . $crisp_val . "<br>";
        echo "SumX =  : " . $sumX . "<br>";
        $this->crispOutput = $crisp_val / $sumX;


        // cetak perhitungan centroid method
        echo "Perhitungan centroid method" . "<br>";
        echo "crisp = " . $this->rendah_final . ' * ('. $pengali_rendah[0];
        for ($i=1; $i < $iRendah; $i++) { 
            echo " + " . $pengali_rendah[$i];
        }
        echo ")";
        for ($i=1; $i < $iOthers; $i++) { 
            echo " + " . $others[$i] . " * " . $pengali_others[$i];
        }
        echo ") + " . $this->tinggi_final . " * " . $pengali_tinggi[0];
        for ($i=1; $i < $iTinggi; $i++) { 
            echo " + " . $pengali_tinggi[$i];
        }
        echo ")) / (" . $this->rendah_final . ' * ' . $iRendah;
        for ($i=0; $i < $iOthers; $i++) { 
            echo " + " . $others[$i];
        }
        echo " + " . $this->tinggi_final . " * " . $iTinggi;
        echo "<br>" . "crisp = " . $this->crispOutput;
    }
}