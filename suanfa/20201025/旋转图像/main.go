/**
  @desc https://leetcode-cn.com/problems/rotate-image/
  @author 伟江
  @date  2020-10-25
*/

package main
import (
	"fmt"
	"three"
)
func main() {
	head := three.CreateList()
	// 矩阵顺时针旋转90°
	head.PrintList();
	var matrix [][]int = [][]int{
		{1, 2, 3},
		{4, 5, 6},
		{7, 8, 9}}
	fmt.Println(matrix)
	three.Rotate(matrix)
	fmt.Println(matrix)
}
