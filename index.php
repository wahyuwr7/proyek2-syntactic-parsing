<?php

session_start();

if (isset($_POST['submit'])) {
    $inputUser = $_POST['input'];
    $conn = mysqli_connect('153.92.10.74', 'u5030462_tbo', 'tbotbo', 'u5030462_tbo');
    $hasil = [];
    function test($input)                                                       //
    {
        global $conn;
        global $hasil;
        if (empty($input)) {
            return 0;
        } else {
            $input2 = explode(' ', $input);
            $query = "SELECT * FROM cnf WHERE terminal LIKE '" . $input2[0] . "%'";
            $result = mysqli_query($conn, $query);
            $result = mysqli_fetch_assoc($result);
            if (is_array($result)) {
                $str = $result['terminal'];
                $rule = $result['rule'];
                $temp = $input;
                $tempResult = substr($temp, 0, strlen($str));
                if (strtoupper($str) == strtoupper($tempResult)) {
                    array_push($hasil, $str);
                    array_push($hasil, $rule);
                    return test(substr($input, strlen($str) + 1));
                } else {
                    return test(substr($input, strlen($input2[0]) + 1));
                }
            } else {
                $str = '';
                $rule = '';
                array_push($hasil, $str);
                array_push($hasil, $rule);
                return test(substr($input, strlen($input2[0]) + 1));
            }
        }
        var_dump($_POST['akurasi']); return false; die();
    }
    test($inputUser);
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>PROJECT TBO</title>
</head>
<style>
    body {
        background-color: thistle;
    }

    .container .form-input {
        background-color: white;
        margin-top: 200px;
        border-radius: 30px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.11),
            0 2px 2px rgba(0, 0, 0, 0.11),
            0 4px 4px rgba(0, 0, 0, 0.11),
            0 6px 8px rgba(0, 0, 0, 0.11),
            0 8px 16px rgba(0, 0, 0, 0.11);
    }

    .title h1 {
        font-weight: 700;
        margin: 50px 0px;
    }

    .input-form {
        padding-left: 10%;
        padding-right: 10%;
        margin-bottom: 50px;
    }

    #result {
        margin-top: -30px;
        margin-bottom: 30px;
    }

    p span {
        font-weight: 700;
    }

    label {
        color: grey;
    }
</style>

<body>
    <script src="jquery.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 form-input">
                <div class="text-center title">
                    <h1>FORM CYK BAHASA BALI</h1>
                </div>
                <div class="input-form">
                    <form action="" class="text-center" method="post">
                        <div class="form-group">
                            <label for="input">Kalimat bahasa bali</label>
                            <input type="text" class="form-control" id="input" aria-describedby="emailHelp" placeholder="Masukkan kalimat bahasa bali" name="input">
                        </div>
                        <input type="hidden" id="akurasi" name="akurasi" value="0">
                        <button id="submit" type="submit" class="btn btn-info" style="width: 25%;" name="submit">Test</button>
                    </form>
                </div>
                <div class="text-center">
                    <p id="result"></p>
                    <p id="result2"></p>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
    <script>
        var grama = {};

        function getRules() {
            let link = 'rule.txt';
            let doc = '';
            $.ajax(link, {
                async: false,
                success: function(data) {
                    doc = data;
                },
                error: function(xhr) {
                    console.log('Error : File ' + link + '\nStatus : ' + xhr.status + ' ' + xhr.statusText);
                }
            });
            return doc;
        }

        function createRules() {
            var grama = {};
            var data = getRules().match(/[^\r\n]+/g);
            var data2 = [];
            var data3 = [];

            for (let i = 0; i < data.length; i++) {
                data2.push(data[i].split('>'));
                for (let j = 0; j < data2[i].length; j++) {
                    data3.push(data2[i][j].split(' '));
                }
            }

            // create object sesuai rule, i = key, i+1 = item
            for (var i = 0; i < data3.length; i = i + 2) {
                if (data3[i + 1].length == 4) {
                    grama[data3[i][0]] = [data3[i + 1][0], data3[i + 1][1], data3[i + 1][2], data3[i + 1][3]];
                } else if (data3[i + 1].length == 5) {
                    grama[data3[i][0]] = [data3[i + 1][0], data3[i + 1][1], data3[i + 1][2], data3[i + 1][3], data3[i + 1][4]];
                } else if (data3[i + 1].length == 6) {
                    grama[data3[i][0]] = [data3[i + 1][0], data3[i + 1][1], data3[i + 1][2], data3[i + 1][3], data3[i + 1][4], data3[i + 1][5]];
                } else if (data3[i + 1].length == 7) {
                    grama[data3[i][0]] = [data3[i + 1][0], data3[i + 1][1], data3[i + 1][2], data3[i + 1][3], data3[i + 1][4], data3[i + 1][5], data3[i + 1][6]];
                } else if (data3[i + 1].length == 8) {
                    grama[data3[i][0]] = [data3[i + 1][0], data3[i + 1][1], data3[i + 1][2], data3[i + 1][3], data3[i + 1][4], data3[i + 1][5], data3[i + 1][6], data3[i + 1][7]];
                } else if (data3[i + 1].length == 12) {
                    grama[data3[i][0]] = [data3[i + 1][0], data3[i + 1][1], data3[i + 1][2], data3[i + 1][3], data3[i + 1][4], data3[i + 1][5], data3[i + 1][6], data3[i + 1][7], data3[i + 1][8], data3[i + 1][9], data3[i + 1][10], data3[i + 1][11]];
                } else if (data3[i + 1].length == 13) {
                    grama[data3[i][0]] = [data3[i + 1][0], data3[i + 1][1], data3[i + 1][2], data3[i + 1][3], data3[i + 1][4], data3[i + 1][5], data3[i + 1][6], data3[i + 1][7], data3[i + 1][8], data3[i + 1][9], data3[i + 1][10], data3[i + 1][11], data3[i + 1][12]];
                } else if (data3[i + 1].length == 14) {
                    grama[data3[i][0]] = [data3[i + 1][0], data3[i + 1][1], data3[i + 1][2], data3[i + 1][3], data3[i + 1][4], data3[i + 1][5], data3[i + 1][6], data3[i + 1][7], data3[i + 1][8], data3[i + 1][9], data3[i + 1][10], data3[i + 1][11], data3[i + 1][12], data3[i + 1][13]];
                } else if (data3[i + 1].length == 21) {
                    grama[data3[i][0]] = [data3[i + 1][0], data3[i + 1][1], data3[i + 1][2], data3[i + 1][3], data3[i + 1][4], data3[i + 1][5], data3[i + 1][6], data3[i + 1][7], data3[i + 1][8], data3[i + 1][9], data3[i + 1][10], data3[i + 1][11], data3[i + 1][12], data3[i + 1][13], data3[i + 1][14], data3[i + 1][15], data3[i + 1][16], data3[i + 1][17], data3[i + 1][18], data3[i + 1][19], data3[i + 1][20]];
                }

            }
            return grama;
        }
        grama = createRules();

        //berfungsi untuk menentukan nilai setiap sel di cyk dimana baris > 0
        var iterasilanjutan = function(tab1, tab2, gram) {
            var wynik = [];
            for (var r in gram) {
                for (var i in gram[r]) {
                    if (tab1.indexOf(gram[r][i].charAt(0)) >= 0 && tab2.indexOf(gram[r][i].charAt(1)) >= 0) {
                        wynik.push(r);
                    }
                }
            }
            // console.log(wynik);
            return wynik;
        };

        function convert(tab) {
            var coba = {
                K: "A",
                S: "B",
                FN: "C",
                Nama: "D",
                P: "E",
                FA: "F",
                Kj: "G",
                O: "H",
                Ket: "I",
                Pn: "J",
                Bd: "K",
                Pr: "L",
                Pel: "M",
                Fp: "N",
                Ps: "O",
                FV: "P",
                Bil: "Q",
                Gt: "R",
                Sf: "S",
                Kt: "T"
            }
            for (let i = 0; i < tab[0].length; i++) {
                tab[0][i] = coba[tab[0][i]];

            }
            return tab;
        }

        //cyk algorytm
        var cyk = function(gram) {
            var len = <?= count($hasil) / 2 ?>;
            //kami mengisi tabel dengan spasi kosong
            var tab = new Array(len);
            for (var t = 0; t < len; t++) {
                tab[t] = new Array(0);
            }

            // menentukan baris pertama cyk
            <?php
            $index = 0;
            for ($z = 0; $z < count($hasil) / 2; $z++) :
            ?>

                tab[0][<?= $z ?>] = '<?= $hasil[$z + $z + 1] ?>'

            <?php endfor; ?>

            tab = convert(tab);
            //iterasi di atas baris
            for (var j = 1; j <= len - 1; j++) {
                //iterasi kolom
                for (var i = 0; i <= len - j - 1; i++) {
                    tab[j][i] = [];
                    //iterasi atas pesanan yang lebih rendah dari kami
                    for (var k = 0; k < j; k++) {
                        //indeks sel yang dibandingkan
                        var baris = j - k - 1;
                        var kolom = i + k + 1;
                        //menambahkan aturan yang sesuai untuk satu pertandingan
                        tab[j][i] = tab[j][i].concat(iterasilanjutan(tab[k][i], tab[baris][kolom], gram));
                    }
                }
            }

            for (var m in tab[len - 1][0]) {
                if (tab[len - 1][0][m] === 'A') {
                    return true;
                }
            }
            return false;

        };

        var test = function() {
            try {
                if (cyk(grama)) {
                    document.getElementById('result').innerHTML = 'Kalimat yang anda input adalah <span>kalimat baku</span>';
                    document.getElementById('akurasi').value = '1';
                } else {
                    document.getElementById('result').innerHTML = 'Kalimat yang anda input adalah <span>kalimat tidak baku</span>';
                    document.getElementById('akurasi').value = '0';
                }
            } catch (error) {
                document.getElementById('result').innerHTML = 'Kalimat yang anda input adalah <span>kalimat tidak baku</span>';
                document.getElementById('akurasi').value = '0';
            }
        };
        test();
    </script>
    <script src="js2.js"></script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>