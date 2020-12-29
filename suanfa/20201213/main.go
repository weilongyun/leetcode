package main

import (
	"./tree"
	"fmt"
)


func main() {

	//binaryTree := tree.Tree{}//建立二叉树
	//binaryTree.TreeAdd(3)
	//binaryTree.TreeAdd(1)
	//binaryTree.TreeAdd(4)
	//binaryTree.TreeAdd(2)
	//
	//
	//qian :=  []int{3,9,20,15,7}
	//zhong := []int{9,3,15,20,7}
	//binaryTree.Root = tree.BuildTree(qian,zhong)
	//fmt.Println("根据前序遍历和中序遍历创建还原二叉树\n")
	//
	//binaryTree.LevelOrder(binaryTree.Root)
	//fmt.Println("层序遍历\n")
	//
	////前序遍历
	//binaryTree.Qian(binaryTree.Root)
	//fmt.Println("递归前序遍历\n")
	//
	//binaryTree.QianUnRecursion(binaryTree.Root)
	//fmt.Println("非递归前序遍历\n")
	//
	////中序遍历
	//binaryTree.Zhong(binaryTree.Root)
	//fmt.Println("递归中序遍历\n")
	////后续遍历
	//binaryTree.Hou(binaryTree.Root)//后
	//fmt.Println("递归后序遍历\n")
	////计算二叉树的最大深度 递归方式
	//fmt.Println("递归遍历二叉树的深度是：",binaryTree.RecursionHeight(binaryTree.Root))
	//fmt.Println("\n")
	////计算二叉树的深度 非递归方式
	//fmt.Println("非递归遍历二叉树的深度是：",binaryTree.Height(binaryTree.Root))
	//fmt.Println("\n")
	//
	//res := binaryTree.KthLargest(binaryTree.Root,1)
	//fmt.Println("第k节点的值是:",res)
	//
	//nums := []int{1,2,3,5,6}
	//twosum := tree.TwoSum(nums,11)
	//fmt.Println("树实现两数之和数组下标：",twosum)
	//
	//
	//table := tree.NewHashTable();
	//for i:=0; i < 20; i++ {
	//	table.Create(i)
	//}
	//table.Print()

	trie := tree.NewTrie();
	trie.Insert("cd")
	trie.Insert("cb")
	trie.Insert("cbjdhghg")
	//trie.Insert("c")
	//fmt.Println(trie.Sreach("c"))
	fmt.Println(trie.SreachAll("c"))
}

