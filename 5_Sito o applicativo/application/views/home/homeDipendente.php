<script src='<?php echo URL; ?>application/public/calendar/lib/main.js'></script>
<script>

    var calendarEl = null
    var calendar = null
    document.addEventListener('DOMContentLoaded', function() {
        var Draggable = FullCalendar.Draggable
        var containerEl = document.getElementById('external-events')
        var checkbox = document.getElementById('drop-remove')

        

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
            editable: false,
            dayMaxEvents: true,

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
                    url: '<?php echo URL; ?>calendario/ottieniEventiDipendente/<?php echo $_SESSION['id']; ?>',
                    method: 'GET',
                    failure: function() {
                        alert('there was an error while fetching events!');
                    }
                }
            ],

            /*events: [
                {
                    id: 2,
                    title: '(1) a',
                    start: '2022-03-17'
                }
            ]*/
            
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
            if (req.readyState === 4){
                var json = JSON.parse(req.response)
                if(json.status == "rollback"){
                    calendar.render()
                    window.alert("Non è stato possibile salvare la configurazione, gli orari impostati non sono corretti")
                }else{
                    var mailReq = new XMLHttpRequest();
                    mailReq.open("GET", "<?php echo URL; ?>mail/invia", true);
                    mailReq.send();
                }
                loading.style.display = "none"
            }
        }

    }
</script>

<div id='calendar-container2'>
  <div id='calendar'></div>
</div>
