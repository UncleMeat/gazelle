 

-- Import the forum
insert ignore into `gazelle`.`forums_posts` (`ID`, `TopicID`, `AuthorID`, `AddedTime`, `Body`, `EditedUserID`, `EditedTime`)
select `id`, `topicid`, `userid`, from_unixtime(`added`), `body`, `editedby`, from_unixtime(`editedat`) from `emp`.`posts`;

--

INSERT ignore INTO gazelle.forums_topics (ID, Title, AuthorID, IsLocked, IsSticky, ForumID, NumPosts, LastPostID, LastPostTime, LastPostAuthorID)
SELECT 
id, 
subject, 
userid, 
0, 
if(sticky='yes', '1', '0') as sticky, 
forumid,
(select count(*) as count from emp.posts where emp.posts.topicid=emp.topics.id) as numposts,
lastpost, 
(select from_unixtime(added) as added from emp.posts where emp.posts.id=emp.topics.id) as time,
(select userid from emp.posts where emp.posts.id=emp.topics.lastpost) as authorid
FROM
emp.topics;

--

insert ignore into gazelle.forums (ID, CategoryID, Sort, Name, Description, NumTopics, NumPosts, LastPostID, LastPostAuthorID, LastPostTopicID, LastPostTime)
select 
id, 
1,
sort, 
Name, 
description, 
topiccount, 
postcount,

(select p.id from emp.topics as t
inner join emp.posts as p on t.id=p.topicid
where t.forumid = emp.forums.id
order by p.added desc limit 1) as LastPostId,

(select p.userid from emp.topics as t
inner join emp.posts as p on t.id=p.topicid
where t.forumid = emp.forums.id
order by p.added desc limit 1) as LastPostAuthorID,

(select p.topicid from emp.topics as t
inner join emp.posts as p on t.id=p.topicid
where t.forumid = emp.forums.id
order by p.added desc limit 1) as LastPostTopicID,

(select from_unixtime(p.added) from emp.topics as t
inner join emp.posts as p on t.id=p.topicid
where t.forumid = emp.forums.id
order by p.added desc limit 1) as LastPostTime

from emp.forums;

--

insert ignore into gazelle.forums_last_read_topics (UserID, TopicID, PostID)
select userid, topicid, lastpostread
from emp.readposts
group by userid, topicid;

-- Import PM's
insert ignore into gazelle.pm_conversations (ID, Subject)
select id, if(subject<>'', subject, 'no subject') as subject from emp.messages;

insert ignore into gazelle.pm_messages (ConvID, SentDate, SenderID, Body)
select id, from_unixtime(added), sender, msg from emp.messages;

insert ignore into gazelle.pm_conversations_users (UserID, ConvID, InInbox, InSentbox, SentDate, ReceivedDate, UnRead)
select sender, id, 0, 1, from_unixtime(added), from_unixtime(added), 0 from emp.messages where sender > 0 and sender <> receiver;

insert ignore into gazelle.pm_conversations_users (UserID, ConvID, InInbox, InSentbox, SentDate, ReceivedDate, UnRead)
select receiver, id, 1, 0, from_unixtime(added), from_unixtime(added), 0 from emp.messages where sender > 0 and sender <> receiver;