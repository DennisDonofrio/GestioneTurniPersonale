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
            <td>
                <i class="bi bi-dash" style="font-size: 25px;cursor: pointer" id="lunediMin"></i>
            </td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Martedì</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="martedi"></i>
            </td>
            <td id="martediDiv"></td>
            <td>
                <i class="bi bi-dash" style="font-size: 25px;cursor: pointer" id="martediMin"></i>
            </td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Mercoledì</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="mercoledi"></i>
            </td>
            <td id="mercolediDiv"></td>
            <td>
                <i class="bi bi-dash" style="font-size: 25px;cursor: pointer" id="mercolediMin"></i>
            </td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Giovedì</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="giovedi"></i>
            </td>
            <td id="giovediDiv"></td>
            <td>
                <i class="bi bi-dash" style="font-size: 25px;cursor: pointer" id="giovediMin"></i>
            </td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Venerdì</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="venerdi"></i>
            </td>
            <td id="venerdiDiv"></td>
            <td>
                <i class="bi bi-dash" style="font-size: 25px;cursor: pointer" id="venerdiMin"></i>
            </td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Sabato</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="sabato"></i>
            </td>
            <td id="sabatoDiv"></td>
            <td>
                <i class="bi bi-dash" style="font-size: 25px;cursor: pointer" id="sabatoMin"></i>
            </td>
        </tr>
        <tr>
            <td>
                <a style="margin-left: 20px;font-size:20px;">Domenica</a>
            </td>
            <td>
                <i class="bi bi-plus" style="font-size: 25px;cursor: pointer" id="domenica"></i>
            </td>
            <td id="domenicaDiv"></td>
            <td>
                <i class="bi bi-dash" style="font-size: 25px;cursor: pointer" id="domenicaMin"></i>
            </td>
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
    var lunediMin = document.getElementById("lunediMin")
    var martediMin = document.getElementById("martediMin")
    var mercolediMin = document.getElementById("mercolediMin")
    var giovediMin = document.getElementById("giovediMin")
    var venerdiMin = document.getElementById("venerdiMin")
    var sabatoMin = document.getElementById("sabatoMin")
    var domenicaMin = document.getElementById("domenicaMin")
    var lunediDiv = document.getElementById("lunediDiv")
    var martediDiv = document.getElementById("martediDiv")
    var mercolediDiv = document.getElementById("mercolediDiv")
    var giovediDiv = document.getElementById("giovediDiv")
    var venerdiDiv = document.getElementById("venerdiDiv")
    var sabatoDiv = document.getElementById("sabatoDiv")
    var domenicaDiv = document.getElementById("domenicaDiv")

    var counters = {
        lunedi : 0,
        martedi : 0,
        mercoledi : 0,
        giovedi : 0,
        venerdi : 0,
        sabato : 0,
        domenica : 0
    }
    
    var giorni = {
        lunedi : "Lunedi",
        martedi : "Martedi",
        mercoledi : "Mercoledi",
        giovedi : "Giovedi",
        venerdi : "Venerdi",
        sabato : "Sabato",
        domenica : "Domenica"
    }

    lunedi.onclick = function(){aggiungiInput(null, null, lunedi, lunediDiv, giorni.lunedi)}
    martedi.onclick = function(){aggiungiInput(null, null, martedi, martediDiv, giorni.martedi)}
    mercoledi.onclick = function(){aggiungiInput(null, null, mercoledi, mercolediDiv, giorni.mercoledi)}
    giovedi.onclick = function(){aggiungiInput(null, null, giovedi, giovediDiv, giorni.giovedi)}
    venerdi.onclick = function(){aggiungiInput(null, null, venerdi, venerdiDiv, giorni.venerdi)}
    sabato.onclick = function(){aggiungiInput(null, null, sabato, sabatoDiv, giorni.sabato)}
    domenica.onclick = function(){aggiungiInput(null, null, domenica, domenicaDiv, giorni.domenica)}

    lunediMin.onclick = function(){rimuoviInput(lunedi, lunediMin, giorni.lunedi)}
    martediMin.onclick = function(){rimuoviInput(martedi, martediMin, giorni.martedi)}
    mercolediMin.onclick = function(){rimuoviInput(mercoledi, mercolediMin, giorni.mercoledi)}
    giovediMin.onclick = function(){rimuoviInput(giovedi, giovediMin, giorni.giovedi)}
    venerdiMin.onclick = function(){rimuoviInput(venerdi, venerdiMin, giorni.venerdi)}
    sabatoMin.onclick = function(){rimuoviInput(sabato, sabatoMin, giorni.sabato)}
    domenicaMin.onclick = function(){rimuoviInput(domenica, domenicaMin, giorni.domenica)}
    
    function aggiungiInput(inizio = null, fine = null, bottone, div, giorno){
        var newInput = document.createElement('select')
        newInput.id = bottone.id + "" + ottieniValoreContatore(giorno)
        newInput.name = bottone.id + "" + ottieniValoreContatore(giorno)
        newInput.innerHTML = ottieniOrari(inizio, fine)
        div.appendChild(newInput)
        aggiungiUnoOMenoUnoAlContatore(giorno, 1)
        if(ottieniValoreContatore(giorno) == 3)
            bottone.style.visibility = "hidden"
        controllaVisibilitaMeno();
    }

    function rimuoviInput(bottonePiu, bottoneMeno, giorno){
        var id = bottonePiu.id + "" + (ottieniValoreContatore(giorno) - 1);
        var elem = document.getElementById(id);
        elem.remove();
        aggiungiUnoOMenoUnoAlContatore(giorno, -1)
        if(ottieniValoreContatore(giorno) == 0)
            bottoneMeno.style.visibility = "hidden"
        else
            bottonePiu.style.visibility = "visible"
    }

    function controllaVisibilitaMeno(){
        if(counters.lunedi < 1)
            lunediMin.style.visibility = "hidden"
        else
            lunediMin.style.visibility = "visible"
        if(counters.martedi < 1)
            martediMin.style.visibility = "hidden" 
        else
            martediMin.style.visibility = "visible"
        if(counters.mercoledi < 1)
            mercolediMin.style.visibility = "hidden"
        else
            mercolediMin.style.visibility = "visible"
        if(counters.giovedi < 1)
            giovediMin.style.visibility = "hidden"
        else
            giovediMin.style.visibility = "visible"
        if(counters.venerdi < 1)
            venerdiMin.style.visibility = "hidden"
        else
            venerdiMin.style.visibility = "visible"
        if(counters.sabato < 1)
            sabatoMin.style.visibility = "hidden"
        else
            sabatoMin.style.visibility = "visible"
        if(counters.domenica < 1)
            domenicaMin.style.visibility = "hidden"
        else
            domenicaMin.style.visibility = "visible"

    }

    function aggiungiUnoOMenoUnoAlContatore(giorno, modo){
        switch(giorno){
            case giorni.lunedi:
                counters.lunedi += 1 * modo
                break
            case giorni.martedi:
                counters.martedi += 1 * modo
                break
            case giorni.mercoledi:
                counters.mercoledi += 1 * modo
                break
            case giorni.giovedi:
                counters.giovedi += 1 * modo
                break
            case giorni.venerdi:
                counters.venerdi += 1 * modo
                break
            case giorni.sabato:
                counters.sabato += 1 * modo
                break
            case giorni.domenica:
                counters.domenica += 1 * modo
                break
        }
    }

    function ottieniValoreContatore(giorno){
        switch(giorno){
            case giorni.lunedi:
                return counters.lunedi
            case giorni.martedi:
                return counters.martedi
            case giorni.mercoledi:
                return counters.mercoledi
            case giorni.giovedi:
                return counters.giovedi
            case giorni.venerdi:
                return counters.venerdi
            case giorni.sabato:
                return counters.sabato
            case giorni.domenica:
                return counters.domenica
        }
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
                    aggiungiInput(json[i]['inizio'], json[i]['fine'], lunedi, lunediDiv, giorni.lunedi)
                    break
                case "Martedì":
                    aggiungiInput(json[i]['inizio'], json[i]['fine'], martedi, martediDiv, giorni.martedi)
                    break
                case "Mercoledì":
                    aggiungiInput(json[i]['inizio'], json[i]['fine'], mercoledi, mercolediDiv, giorni.mercoledi)
                    break
                case "Giovedì":
                    aggiungiInput(json[i]['inizio'], json[i]['fine'], giovedi, giovediDiv, giorni.giovedi)
                    break
                case "Venerdì":
                    aggiungiInput(json[i]['inizio'], json[i]['fine'], venerdi, venerdiDiv, giorni.venerdi)
                    break
                case "Sabato":
                    aggiungiInput(json[i]['inizio'], json[i]['fine'], sabato, sabatoDiv, giorni.sabato)
                    break
                case "Domenica":
                    aggiungiInputDomenica(json[i]['inizio'], json[i]['fine']);
                    break
            }
        }
    }
    
    impostaOrariDefault()
    controllaVisibilitaMeno()
    
</script>