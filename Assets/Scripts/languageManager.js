document.addEventListener('DOMContentLoaded', function() {
    const languageSelect = document.getElementById('languageSelect');
    if (!languageSelect) return;

    // Load saved language preference
    const savedLanguage = localStorage.getItem('selectedLanguage') || 'en';
    languageSelect.value = savedLanguage;

    // Apply translations on page load
    applyTranslations(savedLanguage);

    // Handle language change
    languageSelect.addEventListener('change', function() {
        const selectedLanguage = this.value;
        localStorage.setItem('selectedLanguage', selectedLanguage);
        applyTranslations(selectedLanguage);
    });
});

// Translation objects
const translations = {
    en: {
        dashboard: 'Dashboard',
        catalog: 'Catalog',
        favouriteBooks: 'Favourite Books',
        settings: 'Settings',
        logout: 'LogOut',
        welcome: 'Welcome',
        manageAccounts: 'Manage Accounts',
        manageBooks: 'Manage Books',
        manageStock: 'Manage Stock',
        reports: 'Reports',
        languageSettings: 'Language Settings',
        themeSettings: 'Theme Settings',
        notificationSettings: 'Notification Settings',
        profileSettings: 'Profile Picture Settings',
        lightTheme: 'Light Theme',
        darkTheme: 'Dark Theme',
        bookSphereTheme: 'BookSphere Theme',
        emailNotifications: 'Email Notifications',
        systemNotifications: 'System Notifications',
        updateProfilePicture: 'Update Profile Picture',
        search: 'Search',
        home: 'Home',
        about: 'About',
        contact: 'Contact',
        signUp: 'Sign Up',
        contactUs: 'CONTACT US',
        contactIntro: 'you can get in touch with us through several ways',
        contactTeamDesc: 'get in touch with our team available 24/7',
        contactTeam: 'Contact Team',
        expertAdviceDesc: 'get advices from our experts in the domain',
        callUs: 'Call Us',
        feedbackDesc: 'give us your opinion/observations',
        mailUs: 'Mail Us',
        // Library features
        featuresTitle: 'Features',
        wideSelection: 'Wide Selection of Books',
        wideSelectionDesc: 'Explore our extensive collection of books across various genres.',
        userFriendly: 'User-Friendly Interface',
        userFriendlyDesc: 'Navigate through our platform with ease and find what you need quickly.',
        support: '24/7 Customer Support',
        supportDesc: 'Our support team is here to assist you anytime, anywhere.',
        searchPlaceholder: 'Search for books...',
        readNow: 'Read Now',
        downloadTooltip: 'Download to read later',
        addToFavorite: 'Add to favourite',
        // Stock Management
        suppliersTitle: 'Suppliers',
        addSupplier: 'Add Supplier',
        createOrder: 'Create Order',
        editSupplier: 'Edit Supplier',
        purchaseOrders: 'Purchase Orders',
        createPurchaseOrder: 'Create Purchase Order',
        orderId: 'Order ID',
        supplier: 'Supplier',
        orderDate: 'Order Date',
        totalItems: 'Total Items',
        cost: 'Cost',
        status: 'Status',
        action: 'Action',
        id: 'ID',
        name: 'Name',
        email: 'Email',
        contact: 'Contact',
        address: 'Address',
        actions: 'Actions',
        saveChanges: 'Save Changes',
        addItem: 'Add Item',
        quantity: 'Quantity',
        unitPrice: 'Unit Price',
        description: 'Description',
        removeItem: 'Remove Item',
        pending: 'Pending',
        completed: 'Completed',
        cancelled: 'Cancelled'
    },
    fr: {
        dashboard: 'Tableau de bord',
        catalog: 'Catalogue',
        favouriteBooks: 'Livres favoris',
        settings: 'Paramètres',
        logout: 'Déconnexion',
        welcome: 'Bienvenue',
        manageAccounts: 'Gérer les comptes',
        manageBooks: 'Gérer les livres',
        manageStock: 'Gérer le stock',
        reports: 'Rapports',
        languageSettings: 'Paramètres de langue',
        themeSettings: 'Paramètres du thème',
        notificationSettings: 'Paramètres de notification',
        profileSettings: 'Paramètres de la photo de profil',
        lightTheme: 'Thème clair',
        darkTheme: 'Thème sombre',
        bookSphereTheme: 'Thème BookSphere',
        emailNotifications: 'Notifications par e-mail',
        systemNotifications: 'Notifications système',
        updateProfilePicture: 'Mettre à jour la photo de profil',
        search: 'Rechercher',
        home: 'Accueil',
        about: 'À propos',
        contact: 'Contact',
        signUp: 'Inscription',
        contactUs: 'CONTACTEZ-NOUS',
        contactIntro: 'vous pouvez nous contacter de plusieurs façons',
        contactTeamDesc: 'contactez notre équipe disponible 24h/24 et 7j/7',
        contactTeam: 'Contacter l\'équipe',
        expertAdviceDesc: 'obtenez des conseils de nos experts dans le domaine',
        callUs: 'Appelez-nous',
        feedbackDesc: 'donnez-nous votre avis/observations',
        mailUs: 'Écrivez-nous',
        // Library features
        featuresTitle: 'Caractéristiques',
        wideSelection: 'Large sélection de livres',
        wideSelectionDesc: 'Explorez notre vaste collection de livres dans différents genres.',
        userFriendly: 'Interface conviviale',
        userFriendlyDesc: 'Naviguez sur notre plateforme facilement et trouvez ce dont vous avez besoin rapidement.',
        support: 'Support client 24h/24',
        supportDesc: 'Notre équipe de support est là pour vous aider à tout moment.',
        searchPlaceholder: 'Rechercher des livres...',
        readNow: 'Lire maintenant',
        downloadTooltip: 'Télécharger pour lire plus tard',
        addToFavorite: 'Ajouter aux favoris',
        // Stock Management
        suppliersTitle: 'Fournisseurs',
        addSupplier: 'Ajouter un fournisseur',
        createOrder: 'Créer une commande',
        editSupplier: 'Modifier le fournisseur',
        purchaseOrders: 'Bons de commande',
        createPurchaseOrder: 'Créer un bon de commande',
        orderId: 'ID de commande',
        supplier: 'Fournisseur',
        orderDate: 'Date de commande',
        totalItems: 'Articles totaux',
        cost: 'Coût',
        status: 'Statut',
        action: 'Action',
        id: 'ID',
        name: 'Nom',
        email: 'Email',
        contact: 'Contact',
        address: 'Adresse',
        actions: 'Actions',
        saveChanges: 'Enregistrer',
        addItem: 'Ajouter un article',
        quantity: 'Quantité',
        unitPrice: 'Prix unitaire',
        description: 'Description',
        removeItem: 'Supprimer',
        pending: 'En attente',
        completed: 'Terminé',
        cancelled: 'Annulé'
    },
    es: {
        dashboard: 'Panel de control',
        catalog: 'Catálogo',
        favouriteBooks: 'Libros favoritos',
        settings: 'Configuración',
        logout: 'Cerrar sesión',
        welcome: 'Bienvenido',
        manageAccounts: 'Gestionar cuentas',
        manageBooks: 'Gestionar libros',
        manageStock: 'Gestionar inventario',
        reports: 'Informes',
        languageSettings: 'Configuración de idioma',
        themeSettings: 'Configuración de tema',
        notificationSettings: 'Configuración de notificaciones',
        profileSettings: 'Configuración de foto de perfil',
        lightTheme: 'Tema claro',
        darkTheme: 'Tema oscuro',
        bookSphereTheme: 'Tema BookSphere',
        emailNotifications: 'Notificaciones por correo',
        systemNotifications: 'Notificaciones del sistema',
        updateProfilePicture: 'Actualizar foto de perfil',
        search: 'Buscar',
        home: 'Inicio',
        about: 'Acerca de',
        contact: 'Contacto',
        signUp: 'Registrarse',
        contactUs: 'CONTÁCTENOS',
        contactIntro: 'puede contactarnos de varias formas',
        contactTeamDesc: 'póngase en contacto con nuestro equipo disponible 24/7',
        contactTeam: 'Contactar al equipo',
        expertAdviceDesc: 'obtenga consejos de nuestros expertos en el dominio',
        callUs: 'Llámenos',
        feedbackDesc: 'dénos su opinión/observaciones',
        mailUs: 'Envíenos un correo',
        // Library features
        featuresTitle: 'Características',
        wideSelection: 'Amplia selección de libros',
        wideSelectionDesc: 'Explore nuestra extensa colección de libros en varios géneros.',
        userFriendly: 'Interfaz fácil de usar',
        userFriendlyDesc: 'Navegue por nuestra plataforma con facilidad y encuentre lo que necesita rápidamente.',
        support: 'Soporte al cliente 24/7',
        supportDesc: 'Nuestro equipo de soporte está aquí para ayudarlo en cualquier momento.',
        searchPlaceholder: 'Buscar libros...',
        readNow: 'Leer ahora',
        downloadTooltip: 'Descargar para leer más tarde',
        addToFavorite: 'Añadir a favoritos',
        // Stock Management
        suppliersTitle: 'Proveedores',
        addSupplier: 'Añadir proveedor',
        createOrder: 'Crear pedido',
        editSupplier: 'Editar proveedor',
        purchaseOrders: 'Órdenes de compra',
        createPurchaseOrder: 'Crear orden de compra',
        orderId: 'ID de pedido',
        supplier: 'Proveedor',
        orderDate: 'Fecha de pedido',
        totalItems: 'Total artículos',
        cost: 'Costo',
        status: 'Estado',
        action: 'Acción',
        id: 'ID',
        name: 'Nombre',
        email: 'Correo',
        contact: 'Contacto',
        address: 'Dirección',
        actions: 'Acciones',
        saveChanges: 'Guardar cambios',
        addItem: 'Añadir artículo',
        quantity: 'Cantidad',
        unitPrice: 'Precio unitario',
        description: 'Descripción',
        removeItem: 'Eliminar',
        pending: 'Pendiente',
        completed: 'Completado',
        cancelled: 'Cancelado'
    }
};

function applyTranslations(language) {
    // Get all elements with data-translate attribute
    const elements = document.querySelectorAll('[data-translate]');
    
    elements.forEach(element => {
        const key = element.getAttribute('data-translate');
        if (translations[language] && translations[language][key]) {
            // Special handling for input values
            if (element.tagName === 'INPUT' && element.type === 'submit') {
                element.value = translations[language][key];
            } else if (element.tagName === 'INPUT' && element.type === 'text') {
                element.placeholder = translations[language][key];
            } else {
                element.textContent = translations[language][key];
            }
        }
    });
    
    // Save language preference to session if user is logged in
    updateUserLanguagePreference(language);
}

function updateUserLanguagePreference(language) {
    if (!document.cookie.includes('PHPSESSID')) return;

    fetch('../../Backend/User/updateLanguage.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `language=${language}`
    })
    .catch(error => console.error('Error updating language preference:', error));
}