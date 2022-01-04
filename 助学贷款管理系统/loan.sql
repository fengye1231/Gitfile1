if exists (select * from sys.sysdatabases where[name]='LoanDB')
  drop database LoanDB
go

create database LoanDB



use LoanDB



if exists (select 1 from sysobjects where name='UserInfo')
  drop table UserInfo
go
create table UserInfo --用户信息表
(
  UserId int primary key identity(1,1),		--用户编号
  UserName varchar(50) not null ,			--用户名称
  UserPwd varchar(50) not null,				--用户密码
  Status varchar(30) not null,				--用户身份
  Remark varchar(100),						--备注
)

ALTER TABLE UserInfo						
	ADD CONSTRAINT CK_User_UserPwd check (len(UserPwd) >=6)







if exists(select 1 from sysobjects where name='StudentInfo')
	drop table StudentInfo
go
create table StudentInfo --学生信息表
(
	UserId int not null,					--用户ID
	StuId varchar(20) not null,				--学号
	StuName varchar(50) not null,			--姓名
	StuSex varchar(50) not null,			--性别
	StuIdentity varchar(50) not null,		--身份证号
	EnterSchoolTime varchar(30) not null,	--入学日期
	StuNation varchar(50) not null,			--民族
	StuPolitic varchar(50) not null,		--政治面貌
	StuNative varchar(50) not null,			--籍贯
	StuMobileTel varchar(50) not null,		--移动电话
	StuFamilyTel varchar(50) not null,		--家庭电话	
	Academy varchar(50) not null,			--学院名称
	Classes varchar(50) not null,			--班级
	Major varchar(50) not null,				--专业
	StuRemark varchar(100)					--备注
)

alter table StudentInfo
	add constraint PK_StudentInfo_StuId primary key (StuId)
alter table StudentInfo
	add constraint FK_StudentInfo_UserId foreign key (UserId) references UserInfo(UserId)


if exists(select 1 from sysobjects where name='LoanInfo')
	drop table LoanInfo
go
create table LoanInfo--贷款基本信息表
(
	LoanId varchar(50) not null,			--贷款编号
	LoanAccount decimal(10,2) not null,		--贷款金额
	StuId varchar(20) not null,				--学号
	StuName varchar(50) not null,			--姓名
	StuSex varchar(50) not null,			--性别
	Education varchar(50) not null,			--学历
	SchoolName varchar(50) not null,		--学校
	Major varchar(50) not null,				--专业
	ApplyLoanTime  varchar(30)  not null,	--贷款时间
	Address varchar(100) not null,			--家庭住址
	Remark varchar(100)						--备注
)

alter table LoanInfo
	add constraint PK_LoanInfo_LoanId primary key (LoanId)
alter table LoanInfo
	add constraint FK_LoanInfo_StuId foreign key (StuId) references StudentInfo(StuId)


if exists(select 1 from sysobjects where name='AccountInfo')
	drop table AccountInfo
go
create table AccountInfo
(
	AccountId int primary key identity(1,1) not null,			--账户编号
	LoanId varchar(50) not null,	 							--贷款编号 
	LoanAccount decimal(10,2) not null,							--贷款金额
	PaymentAccount varchar(50) not null,						--还款账号
	PaymentStyle varchar(30) not null,							--还款方式
	Balance decimal(10,2) not null								--贷款余额
)
alter table AccountInfo
	add constraint FK_AccountInfo_LoanId foreign key (LoanId) references LoanInfo(LoanId)




if exists(select 1 from sysobjects where name='ApprovalInfo')
	drop table ApprovalInfo
go
create table ApprovalInfo
(
	ApprovalId int primary key identity(1,1) not null,		--审批编号
	ApprovalStatu varchar(20) not null,						--审批状态
)






if exists(select 1 from sysobjects where name='ApplyInfo')
	drop table ApplyInfo
go
create table ApplyInfo
(
	ApplyId int primary key identity(1,1) not null,		--记录号
	StuName varchar(20) not null,						--姓名
	StuIdentity varchar(50) not null,					--身份证号
	StuMobileTel varchar(50) not null,					--移动电话
	StuFamilyTel varchar(50) not null,					--家庭电话 
	PaymentAccount varchar(50) not null,				--还款账号
	PaymentStyle varchar(30) not null,					--还款方式
	PaymentMoney int,									--还款金额
	LoanId varchar(50) not null,						--贷款编号
	ApprovalId int not null								--审批状态	
)
alter table ApplyInfo
	add constraint FK_ApplyInfo_LoanId foreign key (LoanId) references LoanInfo(LoanId)
alter table ApplyInfo
	add constraint FK_ApplyInfo_ApprovalId foreign key (ApprovalId) references ApprovalInfo(ApprovalId)



create table newsInfo
(
	nid int primary key identity(1,1) not null,     --新闻编号
	title varchar(200),								--新闻标题
	ntime varchar(30),								--发布时间
	fromto varchar(100) 							--出处
)



insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('张三','zhangsan','学生','对自己的信息的所有操作')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('loan','loan123','助贷小组','查看学生贷款信息')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('leader','liader123','院领导','查看学生贷款信息和基本信息')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('admin','admin123','管理员','进行所有操作')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('徐菲','xufei123','学生','对自己的信息的所有操作')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('晓洁','xiaojie','学生','对自己的信息的所有操作')



insert into StudentInfo
	values(1,'200820174001','张三','男','500228198603122045','2010-09-10','汉','团员','渝',
'13147952601','023-86604392','重庆交大','08电信','电子技术','。。。。。')

insert into StudentInfo
	values(5,'200820174023','徐菲','女','500228199007221472','2010-09-10','汉','团员','渝','15835790112',
'18603952627','重庆邮电','08旅游','工商旅游','。。。。。')
insert into StudentInfo
	values(6,'200820174004','晓洁','女','500228198912202544','2008-09-01','汉','团员','渝','15023353623',
'12345678901','重庆文理','08计科','计算机科学','。。。。。')





insert into LoanInfo
	values('CH00000001',6000,'200820174001','张三','男','本科','重庆交大','计电','2008-07-26','重庆市大足县','。。。。。')

insert into LoanInfo
	values('CH00000028',6000,'200820174023','徐菲','女','本科','重庆邮电','旅游','2008-06-22','重庆市奉节县','。。。。。')

insert into LoanInfo
	values('CH00000044',6000,'200820174004','晓洁','女','本科','重庆文理','计科','2009-05-28','重庆市梁平县','。。。。。')




insert into AccountInfo (LoanId,LoanAccount,PaymentAccount,PaymentStyle,Balance)
	values ('CH00000001',6000,'4563516206013716001','分期还款',6000)
insert into AccountInfo (LoanId,LoanAccount,PaymentAccount,PaymentStyle,Balance)
	values ('CH00000028',6000,'4563516206013714702','分期还款',6000)
insert into AccountInfo (LoanId,LoanAccount,PaymentAccount,PaymentStyle,Balance)
	values ('CH00000044',6000,'4563516206013714703','分期还款',6000)



insert into ApprovalInfo (ApprovalStatu) values ('等待审核。。。')
insert into ApprovalInfo (ApprovalStatu) values ('通过初审。。。')
insert into ApprovalInfo (ApprovalStatu) values ('通过审核。。。')




insert into ApplyInfo(StuName,StuIdentity,StuMobileTel,StuFamilyTel,PaymentAccount,PaymentStyle,LoanId,ApprovalId)
	values('张三','500228198603122045','13147952601','023-86604392','4563516206013716082','分期还款','CH00000001',1)
insert into ApplyInfo(StuName,StuIdentity,StuMobileTel,StuFamilyTel,PaymentAccount,PaymentStyle,LoanId,ApprovalId)
	values('徐菲','500228199007221472','15835790112','18603952627','4563516206013714702','分期还款','CH00000028',1)
insert into ApplyInfo(StuName,StuIdentity,StuMobileTel,StuFamilyTel,PaymentAccount,PaymentStyle,LoanId,ApprovalId)
	values('晓洁','500228198912202544','15023353623','12345678901','4563516206013714703','分期还款','CH00000044',1)


select * from UserInfo;
select * from StudentInfo;
select * from AccountInfo;
select * from LoanInfo;
select * from ApprovalInfo;
select * from ApplyInfo;




