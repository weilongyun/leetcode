package main

import (
	"./tree"
	"fmt"
)
func main() {

	tree := tree.Tree{}//建立二叉树
	tree.TreeAdd(10)
	tree.TreeAdd(11)
	tree.TreeAdd(12)
	tree.TreeAdd(9)
	tree.TreeAdd(8)
	tree.TreeAdd(13)

	//前序遍历
	tree.Qian(tree.Root)
	fmt.Println("\n")
	//中序遍历
	tree.Zhong(tree.Root)
	fmt.Println("\n")
	//后续遍历
	tree.Hou(tree.Root)//后
	fmt.Println("\n")

	//计算二叉树的最大深度 递归方式
	fmt.Println("递归遍历二叉树的深度是：",tree.RecursionHeight(tree.Root))
	fmt.Println("\n")
	//计算二叉树的深度 非递归方式
	fmt.Println("非递归遍历二叉树的深度是：",tree.Height(tree.Root))

}

