/**
@desc weilongyun
@date :20201213
*/

package main

import (
	"fmt"
)
// 第二种方式 通过递归方式+切片+把前k大的值放入切片
type TreeNode struct {
	Val int
	Left *TreeNode
	Right *TreeNode
}
var count int
func kthLargest(root *TreeNode, k int) int {
	//定义一个切片
	count = 0
	binarySlice := make([]int,0)
	inverseMediumOrder(root,k,&binarySlice)
	return binarySlice[k-1]

}
// 逆中序遍历 接收TreeNode类型的指针 slice是切片数组
func inverseMediumOrder(root *TreeNode,k int,slice *[]int) {
      //判断递归的截止条件
	if root == nil{
		return
	}
	//右根左
	inverseMediumOrder(root.Right,k,slice)
	if count <k{
		*slice = append(*slice,root.Val)
		count ++
	}
	inverseMediumOrder(root.Left,k,slice)
}
func main(){
	//构造一颗二叉搜索数
	var root *TreeNode = new(TreeNode)
	root.Val = 5
	var s1 *TreeNode = new(TreeNode)
	s1.Val = 3
	root.Left = s1

	var s2 *TreeNode = new(TreeNode)
	s2.Val = 6
	root.Right = s2

	var s3 *TreeNode = new(TreeNode)
	s3.Val = 2
	s1.Left = s3

	var s4 *TreeNode = new(TreeNode)
	s4.Val = 4
	s1.Right = s4

	var s5 *TreeNode = new(TreeNode)
	s5.Val = 1
	s3.Left = s5
	value := kthLargest(root,3)
	fmt.Printf("第k大的值为 %d",value)
}
