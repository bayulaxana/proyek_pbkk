CREATE TABLE Users (
	user_id int not null identity(1,1) PRIMARY KEY,
	username varchar(20) not null,
	password text not null,
	name varchar(50) not null,
	gender char(1) not null,
	address varchar(100) not null,
	register_date date not null,
	role int not null,
	phone varchar(15) not null,
	email varchar(30) not null,
	profile_img varchar(50)
);

CREATE TABLE Service(
	service_id int not null identity(1,1) PRIMARY KEY,
	service_name varchar(50) not null,
	service_photo varchar(50) not null,
	service_price decimal(10,2) not null
);

CREATE TABLE Orders (
	order_id int not null identity(1,1) PRIMARY KEY,
	service_id int FOREIGN KEY REFERENCES Service(service_id) ON DELETE CASCADE,
	user_id int FOREIGN KEY REFERENCES Users(user_id),
	order_total decimal(10,2) not null,
	order_date date not null,
	finish_date date not null,
	order_status varchar(10) not null
);

CREATE TABLE Pickup_Delivery(
	pd_id int not null identity(1,1) PRIMARY KEY,
	order_id int FOREIGN KEY REFERENCES Orders(order_id) ON DELETE CASCADE,
	pd_status varchar(20) not null,
	pd_driver varchar(100),
	pd_type varchar(50) not null,
	pd_time_est date not null
);

CREATE TABLE Payment(
	payment_id int not null identity(1,1) PRIMARY KEY,
	order_id int FOREIGN KEY REFERENCES Orders(order_id) ON DELETE CASCADE,
	admin_id int FOREIGN KEY REFERENCES Users(user_id) ON DELETE CASCADE,
	payment_status varchar(30) not null,
	payment_time date not null
);

CREATE TABLE Goods(
	goods_id int not null identity(1,1) PRIMARY KEY,
	admin_id int FOREIGN KEY REFERENCES Users(user_id) ON DELETE CASCADE,
	goods_name varchar(50) not null,
	unit_price decimal(10,2) not null,
	good_stock int not null
);

CREATE TABLE Expense(
	expense_id int not null identity(1,1) PRIMARY KEY,
	admin_id int FOREIGN KEY REFERENCES Users(user_id) ON DELETE CASCADE,
	expense_note text not null,
	expense_total decimal(10,2) not null,
	invoice varchar(200) not null
);

CREATE TABLE Item(
	item_id int not null identity(1,1) PRIMARY KEY,
	user_id int FOREIGN KEY REFERENCES Users(user_id) ON DELETE CASCADE,
	item_details text not null,
	item_type varchar(10) not null
);

CREATE TABLE Order_Item(
	item_id int FOREIGN KEY REFERENCES Item(item_id) ON DELETE CASCADE,
	order_id int FOREIGN KEY REFERENCES Orders(order_id) ON DELETE CASCADE
);

CREATE TABLE Comment(
	comment_id int not null identity(1,1) PRIMARY KEY,
	user_id int FOREIGN KEY REFERENCES Users(user_id) ON DELETE CASCADE,
	comment_content text not null,
	comment_status varchar(50) not null,
	comment_date date not null
);