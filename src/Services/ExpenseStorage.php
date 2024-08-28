<?php

namespace App\Services;

class Expense
{
    public $id;
    public $description;
    public $amount;
    public $createdAt;
    public $updatedAt;

    public function __construct($id, $description, $amount, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->description = $description;
        $this->amount = $amount;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}

class ExpenseStorage
{
    private $file = 'data.json';
    private $data = [];

    public function __construct()
    {
        if (file_exists($this->file)) {
            $json = file_get_contents($this->file);
            $this->data = json_decode($json, true);
            $this->data = array_map(function ($expense) {
                return new Expense(...$expense);
            }, $this->data);
        }
    }

    public function addExpense($description, $amount)
    {
        if ($amount < 0) {
            return "Amount cannot be negative";
        }

        if (empty($description)) {
            return "Description cannot be empty";
        }

        $amount = (int) $amount;
        $id = count($this->data) + 1;
        $date = date('Y-m-d H:i:s');
        $expense = new Expense($id, $description, $amount, $date, $date);
        $this->data[] = $expense;
        $this->saveToJson();

        return "Expense added successfully (ID: $id)";
    }

    public function listExpenses()
    {
        if (empty($this->data)) {
            return "No expenses found\n";
        }

        $output = "ID  Date       Description  Amount\n";
        foreach ($this->data as $expense) {
            $output .= sprintf(
                "%-3d %-10s %-12s $%-6s\n",
                $expense->id,
                date('Y-m-d', strtotime($expense->createdAt)),
                $expense->description,
                $expense->amount
            );
        }

        return $output;
    }

    public function updateExpense($id, $description, $amount)
    {
        if (empty($this->data)) {
            return "No expenses found\n";
        }

        foreach ($this->data as $key => $expense) {
            if ($expense->id == $id) {
                // Validar si el monto es negativo
                if ($amount < 0) {
                    return "Amount cannot be negative\n";
                }

                // Validar y actualizar la descripción si se proporciona (y no está vacía)
                if ($description !== null && $description !== '') {
                    $this->data[$key]->description = $description;
                }

                // Validar y actualizar el monto si se proporciona (y es un valor numérico válido)
                if ($amount !== null && $amount !== '') {
                    $amount = (int) $amount;
                    $this->data[$key]->amount = $amount;
                }

                // Actualizar la fecha de modificación
                $this->data[$key]->updatedAt = date('Y-m-d H:i:s');
                $this->saveToJson();

                return "Expense (ID: $id) updated successfully\n";
            }
        }

        return "Expense (ID: $id) not found\n";
    }


    public function summaryExpenses($month = null)
    {
        // if (empty($this->data)) {
        //     return "No expenses found\n";
        // }

        // $total = 0;
        // foreach ($this->data as $expense) {
        //     $total += $expense->amount;
        // }

        // return "Total expenses: $$total\n";

        if (empty($this->data)) {
            return "No expenses found\n";
        }

        $total = 0;
        $monthName = '';

        if ($month !== null) {
            $monthName = date('F', mktime(0, 0, 0, $month, 10)); // Convertimos el número de mes en nombre del mes
        }

        foreach ($this->data as $expense) {
            $expenseMonth = date('n', strtotime($expense->createdAt)); // Obtenemos el mes de la fecha de creación del gasto

            if ($month === null || $expenseMonth == $month) {
                $total += $expense->amount;
            }
        }

        if ($month !== null) {
            return "Total expenses for $monthName: $$total\n";
        } else {
            return "Total expenses: $$total\n";
        }
    }

    public function deleteExpenses($id)
    {
        foreach ($this->data as $key => $expense) {
            if ($expense->id == $id) {
                unset($this->data[$key]);
                $this->saveToJson();
                return "Expense deleted successfully\n";
            }
        }

        return "Expense (ID: $id) not found\n";
    }

    public function saveToJson(): void
    {
        $data = array_map(function ($expense) {
            return [
                'id' => $expense->id,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'createdAt' => $expense->createdAt,
                'updatedAt' => $expense->updatedAt,
            ];
        }, $this->data);

        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->file, $json);
    }

    public function saveToCsv(array $data): void
    {
        $fileHandle = fopen($this->file, 'a');
        fputcsv($fileHandle, $data);
        fclose($fileHandle);
    }
}
