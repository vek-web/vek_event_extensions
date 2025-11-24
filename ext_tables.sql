CREATE TABLE tx_sfeventmgt_domain_model_registration
(
	certificate           int(11) unsigned DEFAULT '0' NOT NULL,
	kammer                int(11) unsigned DEFAULT '0' NOT NULL,
	efnnummer             varchar(255) DEFAULT '' NOT NULL,
	reminded              tinyint(4) unsigned DEFAULT '0' NOT NULL,
	linksent              tinyint(4) unsigned DEFAULT '0' NOT NULL,
	certificatecompliance tinyint(4) unsigned DEFAULT '1' NOT NULL,
	certificatesent       tinyint(4) unsigned DEFAULT '0' NOT NULL,
);

CREATE TABLE tx_sfeventmgt_domain_model_event
(
	eventtype                  int(11) unsigned DEFAULT '0' NOT NULL,
	meeting_link               TEXT,
	meeting_id                 varchar(255) DEFAULT '' NOT NULL,
	meeting_additional_id      varchar(255) DEFAULT '' NOT NULL,
	reminder                   tinyint(4) unsigned DEFAULT '1' NOT NULL,
	reminder_period            int(11) DEFAULT '8' NOT NULL,
	reminder_mail              varchar(255) DEFAULT '' NOT NULL,
	reminder_mail_name         varchar(255) DEFAULT '' NOT NULL,
	vnr                        varchar(255) DEFAULT '' NOT NULL,
	certificate_host           varchar(255) DEFAULT '' NOT NULL,
	certificate_supervisor     varchar(255) DEFAULT '' NOT NULL,
	certificate_text           text,
	certificate_event_location varchar(255) DEFAULT '' NOT NULL,
	certificate_location       varchar(255) DEFAULT '' NOT NULL,
	certificate_date           int(11) DEFAULT '0' NOT NULL,
	certificateimage           int(11) unsigned DEFAULT '0' NOT NULL,
	fb_punkte                  int(11) DEFAULT '0' NOT NULL,
);
