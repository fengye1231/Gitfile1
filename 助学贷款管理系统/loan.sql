if exists (select * from sys.sysdatabases where[name]='LoanDB')
  drop database LoanDB
go

create database LoanDB



use LoanDB



if exists (select 1 from sysobjects where name='UserInfo')
  drop table UserInfo
go
create table UserInfo --�û���Ϣ��
(
  UserId int primary key identity(1,1),		--�û����
  UserName varchar(50) not null ,			--�û�����
  UserPwd varchar(50) not null,				--�û�����
  Status varchar(30) not null,				--�û����
  Remark varchar(100),						--��ע
)

ALTER TABLE UserInfo						
	ADD CONSTRAINT CK_User_UserPwd check (len(UserPwd) >=6)







if exists(select 1 from sysobjects where name='StudentInfo')
	drop table StudentInfo
go
create table StudentInfo --ѧ����Ϣ��
(
	UserId int not null,					--�û�ID
	StuId varchar(20) not null,				--ѧ��
	StuName varchar(50) not null,			--����
	StuSex varchar(50) not null,			--�Ա�
	StuIdentity varchar(50) not null,		--���֤��
	EnterSchoolTime varchar(30) not null,	--��ѧ����
	StuNation varchar(50) not null,			--����
	StuPolitic varchar(50) not null,		--������ò
	StuNative varchar(50) not null,			--����
	StuMobileTel varchar(50) not null,		--�ƶ��绰
	StuFamilyTel varchar(50) not null,		--��ͥ�绰	
	Academy varchar(50) not null,			--ѧԺ����
	Classes varchar(50) not null,			--�༶
	Major varchar(50) not null,				--רҵ
	StuRemark varchar(100)					--��ע
)

alter table StudentInfo
	add constraint PK_StudentInfo_StuId primary key (StuId)
alter table StudentInfo
	add constraint FK_StudentInfo_UserId foreign key (UserId) references UserInfo(UserId)


if exists(select 1 from sysobjects where name='LoanInfo')
	drop table LoanInfo
go
create table LoanInfo--���������Ϣ��
(
	LoanId varchar(50) not null,			--������
	LoanAccount decimal(10,2) not null,		--������
	StuId varchar(20) not null,				--ѧ��
	StuName varchar(50) not null,			--����
	StuSex varchar(50) not null,			--�Ա�
	Education varchar(50) not null,			--ѧ��
	SchoolName varchar(50) not null,		--ѧУ
	Major varchar(50) not null,				--רҵ
	ApplyLoanTime  varchar(30)  not null,	--����ʱ��
	Address varchar(100) not null,			--��ͥסַ
	Remark varchar(100)						--��ע
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
	AccountId int primary key identity(1,1) not null,			--�˻����
	LoanId varchar(50) not null,	 							--������ 
	LoanAccount decimal(10,2) not null,							--������
	PaymentAccount varchar(50) not null,						--�����˺�
	PaymentStyle varchar(30) not null,							--���ʽ
	Balance decimal(10,2) not null								--�������
)
alter table AccountInfo
	add constraint FK_AccountInfo_LoanId foreign key (LoanId) references LoanInfo(LoanId)




if exists(select 1 from sysobjects where name='ApprovalInfo')
	drop table ApprovalInfo
go
create table ApprovalInfo
(
	ApprovalId int primary key identity(1,1) not null,		--�������
	ApprovalStatu varchar(20) not null,						--����״̬
)






if exists(select 1 from sysobjects where name='ApplyInfo')
	drop table ApplyInfo
go
create table ApplyInfo
(
	ApplyId int primary key identity(1,1) not null,		--��¼��
	StuName varchar(20) not null,						--����
	StuIdentity varchar(50) not null,					--���֤��
	StuMobileTel varchar(50) not null,					--�ƶ��绰
	StuFamilyTel varchar(50) not null,					--��ͥ�绰 
	PaymentAccount varchar(50) not null,				--�����˺�
	PaymentStyle varchar(30) not null,					--���ʽ
	PaymentMoney int,									--������
	LoanId varchar(50) not null,						--������
	ApprovalId int not null								--����״̬	
)
alter table ApplyInfo
	add constraint FK_ApplyInfo_LoanId foreign key (LoanId) references LoanInfo(LoanId)
alter table ApplyInfo
	add constraint FK_ApplyInfo_ApprovalId foreign key (ApprovalId) references ApprovalInfo(ApprovalId)



create table newsInfo
(
	nid int primary key identity(1,1) not null,     --���ű��
	title varchar(200),								--���ű���
	ntime varchar(30),								--����ʱ��
	fromto varchar(100) 							--����
)



insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('����','zhangsan','ѧ��','���Լ�����Ϣ�����в���')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('loan','loan123','����С��','�鿴ѧ��������Ϣ')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('leader','liader123','Ժ�쵼','�鿴ѧ��������Ϣ�ͻ�����Ϣ')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('admin','admin123','����Ա','�������в���')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('���','xufei123','ѧ��','���Լ�����Ϣ�����в���')
insert into UserInfo (UserName,UserPwd,Status,Remark)
	values ('����','xiaojie','ѧ��','���Լ�����Ϣ�����в���')



insert into StudentInfo
	values(1,'200820174001','����','��','500228198603122045','2010-09-10','��','��Ա','��',
'13147952601','023-86604392','���콻��','08����','���Ӽ���','����������')

insert into StudentInfo
	values(5,'200820174023','���','Ů','500228199007221472','2010-09-10','��','��Ա','��','15835790112',
'18603952627','�����ʵ�','08����','��������','����������')
insert into StudentInfo
	values(6,'200820174004','����','Ů','500228198912202544','2008-09-01','��','��Ա','��','15023353623',
'12345678901','��������','08�ƿ�','�������ѧ','����������')





insert into LoanInfo
	values('CH00000001',6000,'200820174001','����','��','����','���콻��','�Ƶ�','2008-07-26','�����д�����','����������')

insert into LoanInfo
	values('CH00000028',6000,'200820174023','���','Ů','����','�����ʵ�','����','2008-06-22','�����з����','����������')

insert into LoanInfo
	values('CH00000044',6000,'200820174004','����','Ů','����','��������','�ƿ�','2009-05-28','��������ƽ��','����������')




insert into AccountInfo (LoanId,LoanAccount,PaymentAccount,PaymentStyle,Balance)
	values ('CH00000001',6000,'4563516206013716001','���ڻ���',6000)
insert into AccountInfo (LoanId,LoanAccount,PaymentAccount,PaymentStyle,Balance)
	values ('CH00000028',6000,'4563516206013714702','���ڻ���',6000)
insert into AccountInfo (LoanId,LoanAccount,PaymentAccount,PaymentStyle,Balance)
	values ('CH00000044',6000,'4563516206013714703','���ڻ���',6000)



insert into ApprovalInfo (ApprovalStatu) values ('�ȴ���ˡ�����')
insert into ApprovalInfo (ApprovalStatu) values ('ͨ�����󡣡���')
insert into ApprovalInfo (ApprovalStatu) values ('ͨ����ˡ�����')




insert into ApplyInfo(StuName,StuIdentity,StuMobileTel,StuFamilyTel,PaymentAccount,PaymentStyle,LoanId,ApprovalId)
	values('����','500228198603122045','13147952601','023-86604392','4563516206013716082','���ڻ���','CH00000001',1)
insert into ApplyInfo(StuName,StuIdentity,StuMobileTel,StuFamilyTel,PaymentAccount,PaymentStyle,LoanId,ApprovalId)
	values('���','500228199007221472','15835790112','18603952627','4563516206013714702','���ڻ���','CH00000028',1)
insert into ApplyInfo(StuName,StuIdentity,StuMobileTel,StuFamilyTel,PaymentAccount,PaymentStyle,LoanId,ApprovalId)
	values('����','500228198912202544','15023353623','12345678901','4563516206013714703','���ڻ���','CH00000044',1)


select * from UserInfo;
select * from StudentInfo;
select * from AccountInfo;
select * from LoanInfo;
select * from ApprovalInfo;
select * from ApplyInfo;




