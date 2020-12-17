/**
@desc weilongyun
@date :20201213
 */

package main

import "fmt"

type Tree struct {
	Val string
	Left *Tree
	Right *Tree
}
func preOrder(root *Tree){
	if root == nil{
		return
	}
	fmt.Println(root.Val)
	preOrder(root.Left)
	preOrder(root.Right)
}
func mediumOrder(root *Tree){
	if root == nil{
		return
	}
	preOrder(root.Left)
	fmt.Println(root.Val)
	preOrder(root.Right)
}
func afterOrder(root *Tree){
	if root == nil{
		return
	}
	preOrder(root.Left)
	preOrder(root.Right)
	fmt.Println(root.Val)
}
func main() {
	var root *Tree = new(Tree)
	root.Val = "A"
	var s1 *Tree = new(Tree)
	s1.Val = "B"
	root.Left = s1
	preOrder(root)
	fmt.Println("==")
	mediumOrder(root)
	fmt.Println("==")
	afterOrder(root)
}
