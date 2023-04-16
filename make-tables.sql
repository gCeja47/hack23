/* 
by: Gracie Ceja
last modified: April 15, 2023
this file makes the tables for the hsu dating website database.
*/

 
/* five tables: usertbl, has_crush_on, is_dating, not_interested_in, & blocked.
    user is the main table that stores most of user data.
    the other tables show relationships between users.
*/


/* this table contains information about the various users,
   including login information (username & hashed password).

   elaboration on columns:
   ispublic shows whether the user's profile is public (visible on the website without logging in):
   'y' = yes, 'n' = no, 'm' = maybe.
   isusrnmpbulic does the same, except with just their usermame instead of the entire profile

   mbtitype is the mbti personality type. format: INTP-T.

   27 columns total.
*/
drop table usertbl cascade constraints;
create table usertbl(
/* system info */
user_num	int,
username	varchar2(7) NOT NULL,   /* should match their hsu username, e.g. abc123 */
passhash	varchar2(120) NOT NULL,
ispublic    char(1),
isusrnmpbulic    char(1),
/* contact info */
phone_num   int,
email	varchar2(20), 
fb_usr	varchar2(20), 
insta_usr	varchar2(20), 
snap_usr	varchar2(20), 
whatsapp_usr	varchar2(20), 
/* personal characteristics */
bio	    varchar2(150),
fname	varchar2(20) NOT NULL,  /* first name */
mname	varchar2(20),  /* middle name */
lname	varchar2(20),  /* last name */
age     int,
sex     varchar2(8),
studentstatus     varchar2(8),
sexuality     varchar2(11),
mbtitype    char(6),
zodiac	varchar2(20),
chinesezodiac	varchar2(20),
height  varchar2(15),    /* in feet and inches, e.g. 5feet8inches */
haircolor	varchar2(20),
issingle     char(1),
/* preferences */
ismonogamous     char(1),
wantskids     char(1),
primary key(user_num)
);



/* keeps track of users' crushes on other users
    (to notify them in case of a match)
    user_num has a crush on crush_num.
*/
drop table has_crush_on cascade constraints;
create table has_crush_on(
user_num	int,
crush_num	int,
primary key(user_num, crush_num),
foreign key(user_num) references usertbl,
foreign key(crush_num) references usertbl(user_num)
);


/* keeps track of users who are dating each other. */
drop table is_dating cascade constraints;
create table is_dating(
user_num1	int,
user_num2	int,
primary key(user_num1, user_num2),
foreign key(user_num1) references usertbl(user_num),
foreign key(user_num2) references usertbl(user_num)
);


/* keeps track of users' lack of interest in other users
    (to notify the other user in case of an unrequited crush, so they can know to move on)
    user_num is NOT interested in uncrush_num.
*/
drop table not_interested_in cascade constraints;
create table not_interested_in(
user_num	int,
uncrush_num	int,
primary key(user_num, uncrush_num),
foreign key(user_num) references usertbl,
foreign key(uncrush_num) references usertbl(user_num)
);



/* keeps track of users who are blocked by a user.
    user_num blocked blocked_user_num.
    the blocked user can no longer see the other user's profile or send them a message. 
*/
drop table blocked cascade constraints;
create table blocked(
user_num	int,
blocked_user_num	int,
primary key(user_num, blocked_user_num),
foreign key(user_num) references usertbl,
foreign key(blocked_user_num) references usertbl(user_num)
);
