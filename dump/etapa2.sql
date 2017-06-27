/*
Foram implementadas duas queries, uma considerando os
registros em que a relação de departamento e funcionários
não possuem a data_de (to_date) e outra para os que possuem.

A query que para os que não possuem a data_de considera que
os funcionários ainda estão no departamento, sendo utilizada
a data atual.
*/
SELECT 
dept_name AS department_name,
first_name,
last_name,
DATEDIFF(
	IF (dept_emp.to_date IS NOT NULL, dept_emp.to_date, NOW()), 
    dept_emp.from_date
) AS days_on_department,
dept_emp.to_date,
dept_emp.from_date
FROM employees
JOIN dept_emp
ON dept_emp.emp_no = employees.emp_no
JOIN departments
ON dept_emp.dept_no = departments.dept_no
ORDER BY days_on_department desc
LIMIT 10;

SELECT 
dept_name AS department_name,
first_name,
last_name,
DATEDIFF(
	dept_emp.to_date, 
    dept_emp.from_date
) AS days_on_department,
dept_emp.to_date,
dept_emp.from_date
FROM employees
JOIN dept_emp
ON dept_emp.emp_no = employees.emp_no
JOIN departments
ON dept_emp.dept_no = departments.dept_no
ORDER BY days_on_department desc
LIMIT 10;