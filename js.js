var grama = {};
var temp = 'you me me you me you'; // nasze słowo
var w = temp.split(' ');

function getRules() {
    let link = 'rule.txt';
    let doc = '';
    $.ajax(link, {
        async: false,
        success: function (data) {
            doc = data;
        },
        error: function (xhr) {
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
    
    for (var i = 0; i < data3.length; i = i + 2) {
        if (data3[i + 1].length == 3) {
            grama[data3[i][0]] = [data3[i + 1][1], data3[i + 1][2]];
        }
        else {
            grama[data3[i][0]] = [data3[i + 1][1]];
        }
    
    }
    return grama;
}

//berfungsi untuk mengisi baris pertama (tertinggi) dalam sebuah tabel
var iterasiawal = function(litera, gram){
    // console.log(litera);
    var wynik = [];
        for (var r in gram){
          for (var i in gram[r]){   
            if(gram[r][i] === litera){
                wynik.push(r);
            }
          }
        } 
    return wynik;
};

//berfungsi untuk menemukan kunci untuk diberikan dua sel, di mana j> 0
var iterasilanjutan = function(tab1, tab2, gram){
    var wynik = [];
    for (var r in gram){
      for (var i in gram[r]){
        if(tab1.indexOf(gram[r][i].charAt(0))>=0 && tab2.indexOf(gram[r][i].charAt(1))>=0){
            wynik.push(r);
        }
      }
    }
    return wynik;
};

//cyk algorytm
var cyk = function(word,gram){
    var len = word.length;
    //kami mengisi tabel dengan spasi kosong
    var tab = new Array(len);
    for (var t = 0; t < len; t++) {
    tab[t] = new Array(0);
    }
    //kami mengisi baris atas array dengan non-termilans dari rumus dari bentuk NieTerminal -> terminal
    for (var z = 0; z<=len-1; z++){
        tab[0][z] = iterasiawal(word[z], gram);
    }
    //iterasi di atas baris
    for (var j=1; j<=len-1; j++){
        //iterasi kolom
        for (var i=0; i<=len-j-1; i++){
            tab[j][i] = [];
            //iterasi atas pesanan yang lebih rendah dari kami
            for (var k=0;k<j;k++){
                //indeks sel yang dibandingkan
                var pier = j-k-1;
                var drug = i+k+1;
                //menambahkan aturan yang sesuai untuk satu pertandingan
                tab[j][i] = tab[j][i].concat(iterasilanjutan(tab[k][i],tab[pier][drug],gram));
            }
        }
    }
    for (var i = 0; i < tab.length; i++) {
        for(var j = 0; j < tab[i].length; j++){
            console.log(tab[i][j]);
        }
        console.log('\n');
    }


    for (var m in tab[len-1][0]){
        if (tab[len-1][0][m] === 'S'){
            return true;
        }
    }
    return false;
};


var test = function(){
    grama = createRules();
    console.log(cyk(w, grama));
    document.getElementById('text').innerHTML = '' + cyk(w, grama);
};
test();