package main

import (
	"./tree"
	"fmt"
)


func main() {

	binaryTree := tree.Tree{}//建立二叉树
	binaryTree.TreeAdd(10)
	binaryTree.TreeAdd(11)
	binaryTree.TreeAdd(13)
	binaryTree.TreeAdd(9)
	binaryTree.TreeAdd(8)
	binaryTree.TreeAdd(12)

	binaryTree.LevelOrder(binaryTree.Root)
	fmt.Println("层序遍历\n")

	//前序遍历
	binaryTree.Qian(binaryTree.Root)
	fmt.Println("递归前序遍历\n")

	binaryTree.QianUnRecursion(binaryTree.Root)
	fmt.Println("非递归前序遍历\n")

	//中序遍历
	binaryTree.Zhong(binaryTree.Root)
	fmt.Println("递归中序遍历\n")
	//后续遍历
	binaryTree.Hou(binaryTree.Root)//后
	fmt.Println("递归后序遍历\n")
	//计算二叉树的最大深度 递归方式
	fmt.Println("递归遍历二叉树的深度是：",binaryTree.RecursionHeight(binaryTree.Root))
	fmt.Println("\n")
	//计算二叉树的深度 非递归方式
	fmt.Println("非递归遍历二叉树的深度是：",binaryTree.Height(binaryTree.Root))
	fmt.Println("\n")


	nums := []int{1,2,3,5,6}
	res := tree.TwoSum(nums,11)
	fmt.Println("树实现两数之和数组下标：",res)
}

