use paddle_center;

alter table levelSpots
	add originId varchar(90) null after origin;

alter table levelSpots
	add lastMeasurement DATETIME null after river;

alter table levelSpots
	add apiUrl varchar(255) null;

alter table levelSpots
    add temperature decimal(10) null after flow;

create table measurements
(
	id int auto_increment,
	levelSpot int not null,
	timeStamp datetime not null,
	level decimal null,
	flow decimal null,
	temperature decimal null,
	constraint measurements_pk
		primary key (id)
);

alter table measurements
	add constraint measurements_levelSpots_id_fk
		foreign key (levelSpot) references levelSpots (id)
			on delete cascade;


alter table sections modify general_grade varchar(25) null;