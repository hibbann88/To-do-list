<!DOCTYPE html>
<html>
<head>
    <title>🏠 Daftar To-Do Saya</title>
    <style>
        /* Base & Colors */
        :root {
            --color-bg: #f7f9fc;    /* Background super clean */
            --color-card: #ffffff;  /* White card background */
            --color-primary: #007bff; /* Soft Blue accent */
            --color-text-main: #343a40; /* Dark gray for main text */
            --color-text-light: #6c757d; /* Lighter gray for details */
            --color-border: #e9ecef; /* Light border */
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Shadow halus */
        }
        
        /* Header */
        h1 { 
            color: var(--color-primary); 
            border-bottom: 1px solid var(--color-border); 
            padding-bottom: 15px; 
            margin-top: 0;
            font-size: 2em;
            font-weight: 700;
            text-align: center;
        }
        h3 { 
            color: var(--color-text-main); 
            margin-top: 35px; 
            margin-bottom: 15px;
            font-size: 1.2em;
            font-weight: 600;
        }
        hr { border: 0; height: 1px; background: var(--color-border); margin: 30px 0; }

        /* Form Styling */
        .form-group { 
            display: flex; 
            gap: 10px; 
        }
        form input[type="text"] { 
            padding: 12px 15px; 
            flex-grow: 1; 
            border: 1px solid var(--color-border); 
            border-radius: 8px; 
            transition: border-color 0.3s;
        }
        form input[type="text"]:focus {
             border-color: var(--color-primary); 
             outline: none;
             box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        form input[type="submit"] { 
            padding: 12px 20px; 
            background: var(--color-primary); 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600;
            transition: background 0.3s;
        }
        form input[type="submit"]:hover { 
            background: #0056b3; 
        }

        /* List Items (Cards) */
        ul { list-style: none; padding: 0; }
        li { 
            margin-bottom: 15px; 
            padding: 20px; 
            border-radius: 10px; 
            background: var(--color-bg); /* Menggunakan BG kontainer sebagai card color */
            border: 1px solid var(--color-border);
            transition: box-shadow 0.2s, background 0.2s;
        }
        li:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            background: #ffffff;
        }
        li a { 
            text-decoration: none; 
            color: var(--color-text-main);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        li a strong { 
            font-size: 1em; 
            font-weight: 500;
        }
        .date-info {
            font-size: 0.8em;
            color: var(--color-text-light);
            background: #e9f5ff; /* Soft badge background */
            padding: 5px 10px;
            border-radius: 6px;
        }

        /* Utility */
        .error { 
            color: white; 
            background-color: #dc3545; 
            padding: 10px; 
            border-radius: 8px;
            margin-bottom: 20px; 
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Aplikasi To-Do-List 📝</h1>
        
        <h3>+ Buat List Baru</h3>
        <?php if (validation_errors()): ?>
            <div class="error"><?php echo validation_errors(); ?></div>
        <?php endif; ?>
        
        <?php echo form_open('todo/create_list'); ?>
            <div class="form-group">
                <input type="text" name="title" placeholder="Masukkan Judul List Baru..." value="<?php echo set_value('title'); ?>" required>
                <input type="submit" value="Tambah">
            </div>
        <?php echo form_close(); ?>
        
        <hr>

        <h3>Semua Daftar List</h3>
        <?php if (empty($lists)): ?>
            <p style="color: var(--color-text-light); font-style: italic;">Belum ada daftar. Silakan buat yang pertama!</p>
        <?php endif; ?>
        <ul>
            <?php foreach ($lists as $list): ?>
                <li>
                    <a href="<?php echo site_url('todo/view_tasks/'.$list->id); ?>">
                        <strong><?php echo html_escape($list->title); ?></strong>
                        <span class="date-info">Dibuat: <?php echo date('d M Y', strtotime($list->created_at)); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>