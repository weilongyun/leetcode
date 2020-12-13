/**
@desc weilongyun
@date :20201213
*/

package main

import (
	"fmt"
)
// 通过递归方式+标记位求得第k大的值
/*type TreeNode struct {
	Val int
	Left *TreeNode
	Right *TreeNode
}*/
//记录走几步
var skip int
//全局变量记录最终结果
var res int
/*func kthLargest(root *TreeNode, k int) int {
	skip  = k
	inverseMediumOrder(root)
	return res

}
// 逆中序遍历 接收TreeNode类型的指针 slice是切片数组
func inverseMediumOrder(root *TreeNode) {
	//判断递归的截止条件
	if root == nil{
		return
	}
	//右根左
	inverseMediumOrder(root.Right)
  skip --

	if skip ==0 {
		res = root.Val
		return
	}
	inverseMediumOrder(root.Left)
}*/
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
	fmt.Println(s2.Left)
	value := kthLargest(root,3)
	fmt.Printf("第k大的值为 %d",value)
}
