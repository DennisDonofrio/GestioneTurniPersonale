<script src='<?php echo URL; ?>application/public/calendar/lib/main.js'></script>
<script>

    var calendarEl = null
    var calendar = null
    document.addEventListener('DOMContentLoaded', function() {
        var Draggable = FullCalendar.Draggable;
        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');

        new Draggable(containerEl, {
            itemSelector: '.fc-event',
            eventData: function(eventEl) {
            return {
                title: eventEl.innerText
            };
            }
        });

        calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
                right: 'prev,next'
            },
            initialView: 'timeGridWeek',
            height: document.body.clientHeight - 230,
            locale: 'it',
            editable: true,
            dayMaxEvents: true,

            eventClick: function(info) {
                if(window.confirm("Vuoi davvero eliminare questo evento?"))
                    info.event.remove()
            },

            eventMouseEnter: function(info) {
                info.event._def.ui.backgroundColor = '#4374E6'
                calendar.render()
            },

            eventMouseLeave: function(info) {
                info.event._def.ui.backgroundColor = '#3788d8'
                calendar.render()
            },

            eventSources: [
                {
                    url: '<?php echo URL; ?>calendario/ottieniEventi',
                    method: 'GET',
                    failure: function() {
                        alert('there was an error while fetching events!');
                    }
                }
            ]
            
        });
        calendar.render();

        window.addEventListener('resize', function() {
            calendar.setOption('height', document.body.clientHeight - 230)
            calendar.render()
        })

        

    })

    function ottieniEventi(){
        var loading = document.getElementById("loading")
        loading.style.display = "block"
        var events = calendar.getEvents()
        if(events[0] == undefined || events[0] == null){
            loading.style.display = "none"
            return;
        }
        var context = events[0]._context
        var startDate = context.dateProfile.currentRange.start
        var endDate = context.dateProfile.currentRange.end
        var req = new XMLHttpRequest();

        req.open("POST", "<?php echo URL; ?>calendario/salva", true);
        //non riusciva a capire il risultato in json
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

        var jsonEvents = "[";
        
        for(var i = 0; i< events.length;i++){
            jsonEvents += JSON.stringify({
                title: events[i]._def.title, 
                start: events[i]._instance.range.start,
                end: events[i]._instance.range.end
            })
            if(i < events.length - 1){
                jsonEvents += ","
            }
        }
        jsonEvents += "]"

        var range = JSON.stringify(
            {
                start: startDate, 
                end: endDate 
            }
        )

        var request = JSON.stringify({
            range: range,
            events: jsonEvents
        })

        req.send("data=" + request)

        req.onreadystatechange = function() {
            loading.style.display = "none"
            if (req.readyState === 4){
                var json = JSON.parse(req.response)
                if(json.status == "rollback"){
                    calendar.render()
                    window.alert("Non è stato possibile salvare la configurazione, gli orari impostati non sono corretti")
                }else{
                    var mailReq = new XMLHttpRequest()
                    mailReq.open("GET", "<?php echo URL; ?>mail/invia", true)
                    mailReq.send()
                }
                
            }
        }

        
    }
</script>

<div id='save'>
    <input type="submit" class="btn btn-dark" value="Salva" name="salva" onclick="ottieniEventi()">
</div>

<div id='external-events'>
  <p>
    <strong>Dipendenti</strong>
  </p>

    <?php if(!empty($data['dipendenti'])) : ?>
    <?php foreach($data['dipendenti'] as $dipendente): ?>
    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
        <div class='fc-event-main'>
            <?php echo "(" . $dipendente['id'] . ") " .  $dipendente['nome']; ?>
        </div>
    </div>
    <?php endforeach; ?>
    <?php else : ?>
        <p>Non ci sono dipendenti</p>
    <?php endif; ?>
</div>

<div id='calendar-container'>
  <div id='calendar'></div>
</div>

<div class="lds-default" style="position:absolute;top: 50%; left:50%; z-index: 200; display:none" id="loading"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>