package main

import (
	"fmt"
)

func main() {
	str := "{[()]}"
	//str := "{([)]}"
	bool := isValid(str)
	fmt.Println(bool)
}
/**
  @desc https://leetcode-cn.com/problems/valid-parentheses/
  @author 魏龙云
  @date  2020-11-22
*/
func isValid(s string) bool {
	stack := []string{}

	for _, ch := range s {
		c := string(ch)
		if c == "{" || c == "(" || c == "[" {
			stack = append(stack, c)
		} else {
			// 如果此时为空栈，并且不是左括号，说明不是有效的括号
			if len(stack) == 0 {
				return false
			}
			top := stack[len(stack)-1]
			if top == "(" && c == ")" || top == "[" && c == "]" || top == "{" && c == "}" {
				stack = stack[:len(stack)-1]
			} else {
				return false
			}
		}
	}
	return len(stack) == 0
}
