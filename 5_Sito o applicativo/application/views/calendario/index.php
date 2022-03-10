<script src='<?php echo URL; ?>application/public/calendar/lib/main.js'></script>
<script>
    

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

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
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

            eventMouseEnter: function(info) {
                info.event._def.ui.backgroundColor = '#4374E6'
                calendar.render()
            },

            eventMouseLeave: function(info) {
                info.event._def.ui.backgroundColor = '#3788d8'
                calendar.render()
            },

            events: 
                {
                    url: '<?php echo URL; ?>/calendario/ottieniEventi',
                    method: 'GET',
                    failure: function() {
                        alert('there was an error while fetching events!');
                    }
                }
            
        });
        calendar.render();
        window.addEventListener('resize', function() {
            calendar.setOption('height', document.body.clientHeight - 230)
            calendar.render()
        })
    });
    
    console.log()
</script>

<div id='external-events'>
  <p>
    <strong>Dipendenti</strong>
  </p>

  <?php foreach($data['dipendenti'] as $dipendente): ?>
    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
        <div class='fc-event-main'>
            <?php echo $dipendente['nome']; ?>
        </div>
    </div>
  <?php endforeach; ?>
  
</div>

<div id='calendar-container'>
  <div id='calendar'></div>
</div>