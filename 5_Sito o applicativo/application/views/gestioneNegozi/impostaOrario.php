<form method="post" action="<?php echo URL; ?>negozio/salvaOrario">
    <table>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Lunedì</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="lunedi"></i>
            </td>
            <td id="lunediDiv"></td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Martedì</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="martedi"></i>
            </td>
            <td id="martediDiv"></td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Mercoledì</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="mercoledi"></i>
            </td>
            <td id="mercolediDiv"></td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Giovedì</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="giovedi"></i>
            </td>
            <td id="giovediDiv"></td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Venerdì</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="venerdi"></i>
            </td>
            <td id="venerdiDiv"></td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Sabato</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="sabato"></i>
            </td>
            <td id="sabatoDiv"></td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Domenica</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="domenica"></i>
            </td>
            <td id="domenicaDiv"></td>
        </tr>
    </table>
    <input type="submit">
</form>

<div style="display: none;" id="orari">
    <?php echo $data['orari']; ?>
</div>

<div style="display: none;" id="uso">
    <?php echo $data['uso']; ?>
</div>

<script>
    var lunedi = document.getElementById("lunedi")
    var martedi = document.getElementById("martedi")
    var mercoledi = document.getElementById("mercoledi")
    var giovedi = document.getElementById("giovedi")
    var venerdi = document.getElementById("venerdi")
    var sabato = document.getElementById("sabato")
    var domenica = document.getElementById("domenica")
    var lunediDiv = document.getElementById("lunediDiv")
    var martediDiv = document.getElementById("martediDiv")
    var mercolediDiv = document.getElementById("mercolediDiv")
    var giovediDiv = document.getElementById("giovediDiv")
    var venerdiDiv = document.getElementById("venerdiDiv")
    var sabatoDiv = document.getElementById("sabatoDiv")
    var domenicaDiv = document.getElementById("domenicaDiv")
    var counterLunedi = 0;
    var counterMartedi = 0;
    var counterMercoledi = 0;
    var counterGiovedi = 0;
    var counterVenerdi = 0;
    var counterSabato = 0;
    var counterDomenica = 0;

    lunedi.onclick = function(){aggiungiInputLunedi()}
    
    function aggiungiInputLunedi(inizio = null, fine = null) {
        var newInput = document.createElement('select')
        newInput.id = 'lunedi' + counterLunedi;
        newInput.name = 'lunedi' + counterLunedi;
        newInput.innerHTML = ottieniOrari(inizio, fine);
        lunediDiv.appendChild(newInput);
        counterLunedi++
        if(counterLunedi == 3)
            lunedi.style.visibility = "hidden";
    }

    martedi.onclick = function(){aggiungiInputMartedi()}

    function aggiungiInputMartedi(inizio = null, fine = null) {
        var newInput = document.createElement('select')
        newInput.id = 'martedi' + counterMartedi;
        newInput.innerHTML = ottieniOrari(inizio, fine);
        martediDiv.appendChild(newInput);
        counterMartedi++
        if(counterMartedi == 3)
            martedi.style.visibility = "hidden";
    }

    mercoledi.onclick = function(){aggiungiInputMercoledi()}
    
    function aggiungiInputMercoledi(inizio = null, fine = null) {
        var newInput = document.createElement('select')
        newInput.id = 'mercoledi' + counterMercoledi;
        newInput.innerHTML = ottieniOrari(inizio, fine);
        mercolediDiv.appendChild(newInput);
        counterMercoledi++
        if(counterMercoledi == 3)
            mercoledi.style.visibility = "hidden";
    }

    giovedi.onclick =  function(){aggiungiInputGiovedi()}
    
    function aggiungiInputGiovedi(inizio = null, fine = null) {
        var newInput = document.createElement('select')
        newInput.id = 'giovedi' + counterGiovedi;
        newInput.innerHTML = ottieniOrari(inizio, fine);
        giovediDiv.appendChild(newInput);
        counterGiovedi++
        if(counterGiovedi == 3)
            giovedi.style.visibility = "hidden";
    }

    venerdi.onclick = function(){aggiungiInputVenerdi()}

    function aggiungiInputVenerdi(inizio = null, fine = null) {
        var newInput = document.createElement('select')
        newInput.id = 'venerdi' + counterVenerdi;
        newInput.innerHTML = ottieniOrari(inizio, fine);
        venerdiDiv.appendChild(newInput);
        counterVenerdi++
        if(counterVenerdi == 3)
            venerdi.style.visibility = "hidden";
    }

    sabato.onclick = function(){aggiungiInputSabato()}
    
    function aggiungiInputSabato(inizio = null, fine = null) {
        var newInput = document.createElement('select')
        newInput.id = 'sabato' + counterSabato;
        newInput.name = 'sabato' + counterSabato;
        newInput.innerHTML = ottieniOrari(inizio, fine);
        sabatoDiv.appendChild(newInput);
        counterSabato++
        if(counterSabato == 3)
            sabato.style.visibility = "hidden";
    }

    domenica.onclick = function(){aggiungiInputDomenica()}
    
    function aggiungiInputDomenica(inizio = null, fine = null) {
        var newInput = document.createElement('select')
        newInput.id = 'domenica' + counterDomenica;
        newInput.innerHTML = ottieniOrari(inizio, fine);
        domenicaDiv.appendChild(newInput);
        counterDomenica++
        if(counterDomenica == 3)
            domenica.style.visibility = "hidden";
    }

    function ottieniOrari(inizio, fine){
        var out = "";
        var json = JSON.parse(document.getElementById("orari").innerHTML)
        for(var i=0;i<json.length;i++){
            if(inizio == json[i]['inizio'] && fine == json[i]['fine']){
                out += "<option value='" + json[i]['id'] + "' selected>" + json[i]['inizio'] + "-" + json[i]['fine'] + "</option>"
            }else{
                out += "<option value='" + json[i]['id'] + "'>" + json[i]['inizio'] + "-" + json[i]['fine'] + "</option>"
            }
        }
        return out;
    }

    function impostaOrariDefault(){
        var json = JSON.parse(document.getElementById("uso").innerHTML)
        for(var i=0;i<json.length;i++){
            switch(json[i]['nome']){
                case "Lunedì":
                    aggiungiInputLunedi(json[i]['inizio'], json[i]['fine'])
                    break
                case "Martedì":
                    aggiungiInputMartedi(json[i]['inizio'], json[i]['fine']);
                    break
                case "Mercoledì":
                    aggiungiInputMercoledi(json[i]['inizio'], json[i]['fine']);
                    break
                case "Giovedì":
                    aggiungiInputGiovedi(json[i]['inizio'], json[i]['fine']);
                    break
                case "Venerdì":
                    aggiungiInputVenerdi(json[i]['inizio'], json[i]['fine']);
                    break
                case "Sabato":
                    aggiungiInputSabato(json[i]['inizio'], json[i]['fine']);
                    break
                case "Domenica":
                    aggiungiInputDomenica(json[i]['inizio'], json[i]['fine']);
                    break
            }
        }
    }

    impostaOrariDefault()
</script>