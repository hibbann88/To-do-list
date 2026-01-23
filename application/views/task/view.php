<!DOCTYPE html>
<html>
<head>
    <title>✅ Tugas: <?php echo html_escape($list->title); ?></title>
    <style>
        /* Base & Colors (Sama dengan list/index.php) */
        :root {
            --color-bg: #f7f9fc;    /* Background super clean */
            --color-card: #ffffff;  /* White card background */
            --color-primary: #007bff; /* Soft Blue accent */
            --color-text-main: #343a40; /* Dark gray for main text */
            --color-text-light: #6c757d; /* Lighter gray for details */
            --color-border: #e9ecef; /* Light border */
            
            /* Status Colors */
            --status-pending: #dc3545; /* Merah */
            --status-in-progress: #ffc107; /* Kuning/Orange */
            --status-completed: #28a745; /* Hijau */
        }

        body { 
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 50px 0;
            background: var(--color-bg); 
            color: var(--color-text-main);
        }
        .container { 
            max-width: 600px; 
            margin: auto; 
            background: var(--color-card); 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        /* Header & Navigation */
        h1 { 
            color: var(--color-primary); 
            border-bottom: 1px solid var(--color-border); 
            padding-bottom: 15px; 
            margin-top: 0;
            font-size: 1.8em;
            font-weight: 700;
        }
        h2 {
            color: var(--color-text-main); 
            margin-top: 30px; 
            margin-bottom: 15px;
            font-size: 1.2em;
            font-weight: 600;
        }
        .back-link {
            color: var(--color-text-light);
            text-decoration: none;
            font-size: 0.9em;
            display: block;
            margin-bottom: 20px;
        }
        hr { border: 0; height: 1px; background: var(--color-border); margin: 30px 0; }

        /* Form Tambah Tugas */
        form label { font-weight: 600; display: block; margin-bottom: 5px; font-size: 0.9em; }
        form input[type="text"],
        form input[type="date"] {
            padding: 10px 12px; 
            border: 1px solid var(--color-border); 
            border-radius: 8px; 
            transition: border-color 0.3s;
            box-sizing: border-box; /* Penting untuk width: 100% */
        }
        form input[type="text"]:focus,
        form input[type="date"]:focus {
            border-color: var(--color-primary);
            outline: none;
        }
        form input[type="submit"] {
            padding: 10px 20px; 
            background: var(--status-completed); /* Hijau untuk Simpan */
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        /* Status Badges */
        .pending { color: var(--status-pending); font-weight: bold; background: #fff0f3; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; }
        .in_progress { color: var(--status-in-progress); font-weight: bold; background: #fff7e6; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; }
        .completed { color: var(--status-completed); font-weight: bold; background: #e6ffed; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; }

        /* Task Items (Cards) */
        .task-item { 
            border: 1px solid var(--color-border); 
            margin-bottom: 15px; 
            padding: 20px; 
            border-radius: 10px; 
            background: var(--color-card); 
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
            transition: box-shadow 0.2s;
        }
        .task-item:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
        .task-item p { margin-top: 0; margin-bottom: 10px; font-size: 1.1em; }

        /* Date Info */
        .date-info { 
            font-size: 0.8em; 
            color: var(--color-text-light); 
            margin-top: 8px; 
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--color-border);
        }
        .date-info strong { color: var(--color-text-main); }
        
        /* Action Links */
        .action-links { margin-top: 15px; }
        .action-links a { 
            margin-right: 15px; 
            text-decoration: none; 
            font-weight: 500;
            font-size: 0.9em;
            transition: opacity 0.2s;
        }
        .action-links a:hover { opacity: 0.8; }
        
        /* Utility */
        .error { 
            color: white; 
            background-color: var(--status-pending); /* Merah untuk error */
            padding: 10px; 
            border-radius: 8px;
            margin-bottom: 20px; 
            font-weight: 500;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo site_url('todo'); ?>" class="back-link">← Kembali ke Daftar Utama</a>
        
        <h1>Daftar Tugas: <?php echo html_escape($list->title); ?></h1>

        <h2>+ Tambah Tugas Baru</h2>
        <?php if (validation_errors()): ?>
            <div class="error"><?php echo validation_errors(); ?></div>
        <?php endif; ?>
        
        <?php echo form_open('todo/add_task/' . $list->id); ?>
            <label for="description">Judul Tugas:</label><br>
            <input type="text" name="description" value="<?php echo set_value('description'); ?>" required style="width: 100%;"><br>
            <br>
            <label for="target_date">Tanggal Target:</label>
            <input type="date" name="target_date" value="<?php echo set_value('target_date'); ?>" required style="margin-right: 10px;">
            <input type="submit" value="Simpan Tugas">
        <?php echo form_close(); ?>

        <hr>

        <h2>Daftar Tugas (<?php echo isset($tasks) ? count($tasks) : 0; ?>)</h2>
        
        <?php if (!isset($tasks) || empty($tasks)): ?>
            <p style="color: var(--color-text-light); font-style: italic;">Tidak ada tugas dalam daftar ini.</p>
        <?php endif; ?>

        <?php if (isset($tasks) && is_array($tasks)): foreach ($tasks as $task): ?>
            <div class="task-item">
                <p>
                    <strong><?php echo html_escape($task->description); ?></strong> 
                    <span class="<?php echo $task->status; ?>"><?php echo ucfirst(str_replace('_', ' ', $task->status)); ?></span>
                </p>
                
                <div class="date-info">
                    Dibuat: <?php echo date('d M Y', strtotime($task->created_date)); ?> | 
                    **Target: <?php echo date('d M Y', strtotime($task->target_date)); ?>**
                </div>
                
                <div class="action-links">
                    <?php if ($task->status !== 'completed'): ?>
                        <a href="<?php echo site_url("todo/update_status/{$list->id}/{$task->id}/completed"); ?>" style="color: var(--status-completed);">Selesai</a> |
                        <a href="<?php echo site_url("todo/update_status/{$list->id}/{$task->id}/in_progress"); ?>" style="color: var(--status-in-progress);">Proses</a> |
                    <?php endif; ?>
                    
                    <a href="<?php echo site_url("todo/edit_task_form/{$list->id}/{$task->id}"); ?>" style="color: var(--color-primary);">Ubah</a> |
                    <a href="<?php echo site_url("todo/delete_task/{$list->id}/{$task->id}"); ?>" onclick="return confirm('Yakin ingin menghapus tugas ini?')" style="color: var(--status-pending);">Hapus</a>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</body>
</html>