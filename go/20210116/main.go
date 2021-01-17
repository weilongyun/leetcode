package main

import (
	"encoding/json"
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"github.com/jmoiron/sqlx"
	"log"
	"net/http"
	"strconv"
)


/*
classify | CREATE TABLE `classify` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
	`name` varchar(50) NOT NULL DEFAULT '' COMMENT 'first',
	`pid` int(11) unsigned NOT NULL DEFAULT '0',
	`level` int(11) unsigned NOT NULL DEFAULT '0',
	`create_time` int(11) NOT NULL,
	`update_time` int(11) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 |
 */

type Hobby struct {
	Id         int64  `db:"id"`
	Name       string `db:"name"`
	Pid        int64  `db:"pid"`
	Level      int64  `db:"level"`
	CreateTime int64  `db:"create_time"`
	UpdateTime int64  `db:"update_time"`
}

type Kind struct {
	Id       int64	`json:"id"`
	Name     string `json:"name"`
	Children []map[string]interface{}	`json:"children"`
}

var db *sqlx.DB

func init() {
	database, _ := sqlx.Open("mysql", "root:123456@(192.168.0.101)/db002")
	err := database.Ping()
	if err != nil {
		fmt.Println("链接数据库失败！:", err)
	} else {
		fmt.Println("数据库链接成功！")
		db = database
	}
}

func index(w http.ResponseWriter, r *http.Request) {

	var hbs []Hobby
	query := "select * from classify where pid=0"
	err := db.Select(&hbs, query)
	if err != nil {
		fmt.Println(err)
	}
	//fmt.Fprintln(w,hbs)
	// 1、先查出一级分类
	tital := make([]Kind, 0)
	for _, val := range hbs {
		// 一级id
		query = "select * from classify where pid=" + strconv.Itoa(int(val.Id))
		// 二级数据
		var hbs1 []Hobby
		err = db.Select(&hbs1, query)
		// fmt.Fprintln(w, hbs1)
		slice := make([]map[string]interface{}, 0)
		for _, val := range hbs1 {
			m1 := make(map[string]interface{}, 0)
			m1["id"] = val.Id
			m1["name"] = val.Name
			slice = append(slice, m1)
		}
		k1 := Kind{
			Id:       val.Id,
			Name:     val.Name,
			Children: slice,
		}
		tital = append(tital, k1)
	}
	res, _ := json.Marshal(tital)
	fmt.Fprintln(w, string(res))
	// 4、转成json串
	// 5、返回客户端展示
}

func main() {
	defer db.Close()
	http.HandleFunc("/index", index)
	err := http.ListenAndServe(":8081", nil)
	if err != nil {
		log.Panic("err info is ", err)
	}

}
