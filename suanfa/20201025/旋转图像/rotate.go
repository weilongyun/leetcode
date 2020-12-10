package three
func Rotate(matrix [][]int) {
	for i :=0 ; i < len(matrix); i++ {
		for j := 0; j < i; j++ {
			tmp := matrix[i][j]
			matrix[i][j] = matrix[j][i]
			matrix[j][i] = tmp
		}
	}
	for i :=0 ; i < len(matrix) / 2; i++ {
		for j := 0; j < len(matrix); j++ {
			tmp := matrix[j][i]
			matrix[j][i] = matrix[j][len(matrix) - 1 - i]
			matrix[j][len(matrix) - 1 - i] = tmp
		}
	}
	return
}
