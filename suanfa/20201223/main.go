package main

import (
	"./shortUrlGenerator"
	"fmt"
)
/*
	go url生成短链算法
*/


func main() {
	url := "https://www.bilibili.com/"
	res := shortUrlGenerator.MakeShortCode(url)
	fmt.Print(res)
}


