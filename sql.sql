CREATE TABLE categoria (
`id` int(11) NOT NULL key AUTO_INCREMENT, 
`nome` varchar(33), 
`noticia_id` int(11), 
foreign key (`noticia_id`) REFERENCES noticia(`id`));