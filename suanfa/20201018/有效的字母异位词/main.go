/**
  @desc https://leetcode-cn.com/problems/valid-anagram/
  @author 王宇
  @date  2020-10-18
*/
func isAnagram1(s string, t string) bool {
	var sTmpMap = make(map[rune]int)
	var tTmpMap = make(map[rune]int)
	for _, c := range s {
	sTmpMap[c] = sTmpMap[c] + 1
	}
	for _, c := range t {
	sTmpMap[c] = tTmpMap[c] + 1
	}
	return reflect.DeepEqual(sMap, tMap)
}


