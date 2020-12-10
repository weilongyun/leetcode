/**
  @desc https://leetcode-cn.com/problems/palindrome-number/
  @author 王宇
  @date  2020-11-01
*/

/**
 回文数：
1. 定义：回文数是指正序（从左向右）和倒序（从右往左）读都是一样的整数

方法1：数字转换成字符串
        举例：整数X：1 2 3 2 1
                   字符串：“1” “2” “3” “2” “1”
                   反序字符串：“1” “2” “3” “2” “1”
        判断方法：判断字符串和反序字符串是否完全相同
        进阶判断方法：判断字符串的前面一半和后面一半是否完全相同就可以
 */
func isPalindrome(x int) bool {
	str:=strconv.Itoa(x)
	j:=len(str)-1
	for i:=0;i<len(str)/2;i++{
		if str[i]!=str[j]{
		return false
		}
		j--
	}
	return true
}
/**
方法2：将数字本身进行反转
但是这个方法可能会产生数字越界的情况，因此借鉴方法一中进阶解法，就是反转一半数字
负数：- 1 2 3 2 1  负数不可以反转
非负数:
            奇数位(关于3对称)
            1 2 3 2 1
            偶数位(关于 2 之间的虚线对称)
            1 2 | 2 1
设置revertedNumber 存储反转后的结果，进行取余的操作，将获取的数字存储到revertedNunber中，之后进行除10的操作，完成舍去最后一位的操作，以此类推进行操作，多次进行上面的过程，我们将得到更多位数的反转数字。
判断终止的条件：当原始数字小于或等于反转后的数字的时候，就意味这我们已经处理了一半位数的数字了。
 */
func isPalindrome(x int) bool {
// 特殊情况1：如上所述，当 x < 0 时，x 不是回文数。
	if x < 0 {
	return false
	}

// 特殊情况2：如果数字的最后一位是 0，为了使该数字为回文，则其第一位数字也应该是：0只有 0 满足这一属性
	if x % 10 == 0 && x != 0 {
	return false
	}

// 循环建立反转一半的数字
	revertedNumber := 0
	for x > revertedNumber {
	revertedNumber = revertedNumber * 10 + x % 10
	x /= 10
	}
// 奇数和偶数分别判断
	return x == revertedNumber || x == revertedNumber / 10
}
//时间复杂度：O(logn)，这个时间复杂度不是很理解
//空间复杂度：O(1)
