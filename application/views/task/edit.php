<!DOCTYPE html>
<html>
<head>
    <title>✍️ Ubah Tugas</title>
    <style>
        /* Base & Colors (Sama dengan tampilan sebelumnya) */
        :root {
            --color-bg: #f7f9fc;    
            --color-card: #ffffff;  
            --color-primary: #007bff; /* Soft Blue accent */
            --color-text-main: #343a40; 
            --color-text-light: #6c757d; 
            --color-border: #e9ecef; 
            --color-submit: #007bff; /* Biru untuk tombol simpan */
            --color-cancel: #6c757d; /* Abu-abu untuk batal */
            --color-error: #dc3545;
        }

        body { 
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 50px 0;
            background: var(--color-bg); 
            color: var(--color-text-main);
        }
        .container { 
            max-width: 500px; /* Lebar lebih kecil karena ini form */
            margin: auto; 
            background: var(--color-card); 
            padding: 35px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        /* Header */
        h1 { 
            color: var(--color-primary); 
            border-bottom: 1px solid var(--color-border); 
            padding-bottom: 15px; 
            margin-top: 0;
            font-size: 1.8em;
            font-weight: 700;
        }
        
        /* Form Styling */
        label { 
            font-weight: 600; 
            display: block; 
            margin-bottom: 5px; 
            margin-top: 15px;
            font-size: 0.95em;
        }
        input[type="text"], 
        input[type="date"], 
        select { 
            padding: 12px 15px; 
            border: 1px solid var(--color-border); 
            border-radius: 8px; 
            margin-bottom: 10px; 
            width: 100%; 
            box-sizing: border-box;
            transition: border-color 0.3s;
            background: #fcfcfc;
        }
        input[type="text"]:focus, 
        input[type="date"]:focus, 
        select:focus {
             border-color: var(--color-primary); 
             outline: none;
        }
        
        /* Buttons */
        input[type="submit"] { 
            padding: 12px 20px; 
            background: var(--color-submit); 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600;
            transition: background 0.3s;
            width: auto; /* Agar tidak 100% */
        }
        input[type="submit"]:hover { 
            background: #0056b3; 
        }

        /* Footer Link */
        p a {
            color: var(--color-cancel);
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            padding: 8px 0;
            font-weight: 500;
            transition: color 0.3s;
        }
        p a:hover {
            color: var(--color-text-main);
        }

        /* Utility */
        .error { 
            color: white; 
            background-color: var(--color-error); 
            padding: 10px; 
            border-radius: 8px;
            margin-bottom: 20px; 
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ubah Detail Tugas</h1>
        
        <?php if (validation_errors()): ?>
            <div class="error"><?php echo validation_errors(); ?></div>
        <?php endif; ?>
        
        <?php echo form_open('todo/update_task/' . $list_id . '/' . $task->id); ?>
            
            <label for="description">Deskripsi Tugas:</label>
            <input type="text" name="description" value="<?php echo set_value('description', $task->description); ?>" required>

            <label for="target_date">Tanggal Target:</label>
            <input type="date" name="target_date" value="<?php echo set_value('target_date', $task->target_date); ?>" required>

            <label for="status">Status:</label>
            <select name="status">
                <option value="pending" <?php echo (set_value('status', $task->status) == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="in_progress" <?php echo (set_value('status', $task->status) == 'in_progress') ? 'selected' : ''; ?>>Dalam Proses</option>
                <option value="completed" <?php echo (set_value('status', $task->status) == 'completed') ? 'selected' : ''; ?>>Selesai</option>
            </select>

            <input type="submit" value="Simpan Perubahan">
        <?php echo form_close(); ?>

        <p><a href="<?php echo site_url('todo/view_tasks/' . $list_id); ?>">← Batal dan Kembali</a></p>
    </div>
</body>
</html>