package main

import (
	"./tree"
	"fmt"
)
func main() {
	tree := tree.Tree{}
	tree.TreeAdd(10)
	tree.TreeAdd(11)
	tree.TreeAdd(12)
	tree.TreeAdd(9)
	tree.TreeAdd(8)
	tree.TreeAdd(13)

	tree.Qian(tree.Root)//前
	fmt.Println("\n")
	tree.Zhong(tree.Root)//中
	fmt.Println("\n")
	tree.Hou(tree.Root)//后

}

