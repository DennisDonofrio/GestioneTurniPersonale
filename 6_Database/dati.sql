
insert into datore values (1, "Andrea", "Curti", "a.c@gmail.com", "bc7353cb7ab19d65ac5474e2d47433935c4b67b4e66a9525d72676ba537dfa25", "Via san bartolomeo", 0);
insert into dipendente values (1, "Dennis", "Donofrio", "d.d@gmail.com", "03b7916c647cb13a0622fb9c3b9b4a6efaeaa72b03e8463fe2e1e4b0c7a33dbe", "Via Taverne", 1, 0);
insert into dipendente values (2, "Gioele", "Zanetti", "g.z@gmail.com", "b70b6d646df6917df9016a3d37a4c1c28001550f943b29a7c6ce1118a4da2fba", "Via Quadrella Manno", 1, 0);
insert into amministratore values (1, "Admin", "", "admin@gmail.com", "bd0b82f16357b637a9cd85bebdf267a9dcccd1fbcf5bbcdc07323cedbb9a319d", "", 0);

insert into tipo values(1, 'Alimentari', 'Cibo e bevande');
insert into tipo values(2, 'Vestiario', 'Qualsiasi tipo di vestito');

insert into negozio values(1, 'Panetteria Donofrio', 'Via bramboi', 0, 1, 1);
insert into negozio values(2, 'Alimentari Curti Antonio', 'Via Fontana 23', 0, 1, 1);

insert into orario values(1, '08:00:00', '12:30:00');
insert into orario values(2, '14:00:00', '18:00:00');
insert into orario values(3, '09:00:00', '18:30:00');
insert into orario values(4, '08:00:00', '23:00:00');
insert into orario values(5, '23:00:00', '07:00:00');

insert into giorno values(1,'Lunedì', '1');
insert into giorno values(2,'Martedì', '1');
insert into giorno values(3,'Mercoledì', '1');
insert into giorno values(4,'Giovedì', '1');
insert into giorno values(5,'Venerdì', '1');
insert into giorno values(6,'Sabato', '1');
insert into giorno values(7,'Domenica', '1');

insert into orario_turno values('08:00:00', '10:00:00');
insert into orario_turno values('10:00:00', '12:30:00');
insert into orario_turno values('14:00:00', '16:00:00');
insert into orario_turno values('16:00:00', '18:00:00');
insert into orario_turno values('23:00:00', '07:00:00');
insert into orario_turno values('18:00:00', '23:00:00');

insert into usa values(1, 1, 1, 1);
insert into usa values(1, 1, 2, 1);
insert into usa values(1, 2, 1, 1);
insert into usa values(1, 2, 2, 1);
insert into usa values(1, 3, 1, 1);
insert into usa values(1, 3, 2, 1);
insert into usa values(1, 4, 1, 1);
insert into usa values(1, 4, 2, 1);
insert into usa values(1, 5, 1, 1);
insert into usa values(1, 5, 2, 1);

select o.inizio, o.fine, n.nome, g.nome 
from orario o 
inner join usa u 
on u.orario_id = o.id 
inner join negozio n 
on u.negozio_id = n.id 
inner join giorno g 
on u.giorno_id = g.id;

insert into prevede values(1, '08:00:00', '10:00:00');
insert into prevede values(1, '10:00:00', '12:30:00');
insert into prevede values(1, '14:00:00', '16:00:00');
insert into prevede values(1, '16:00:00', '18:00:00');

insert into turno_lavoro values(1, 1, '08:00:00', '10:00:00', '2022-02-17');
insert into turno_lavoro values(1, 1, '10:00:00', '12:30:00', '2022-02-17');
insert into turno_lavoro values(2, 1, '14:00:00', '16:00:00', '2022-02-17');
insert into turno_lavoro values(2, 1, '16:00:00', '18:00:00', '2022-02-17');
