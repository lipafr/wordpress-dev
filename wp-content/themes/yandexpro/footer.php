{
    "version": 2,
    "customTemplates": [
        {
            "name": "page-landing",
            "title": "Лендинг",
            "postTypes": ["page"]
        },
        {
            "name": "page-blog",
            "title": "Страница блога",
            "postTypes": ["page"]
        },
        {
            "name": "page-contact",
            "title": "Контакты",
            "postTypes": ["page"]
        }
    ],
    "settings": {
        "appearanceTools": true,
        "useRootPaddingAwareAlignments": true,
        "color": {
            "palette": [
                {
                    "color": "#2c3e50",
                    "name": "Основной",
                    "slug": "primary"
                },
                {
                    "color": "#7f8c8d",
                    "name": "Вторичный",
                    "slug": "secondary"
                },
                {
                    "color": "#3498db",
                    "name": "Акцентный",
                    "slug": "accent"
                },
                {
                    "color": "#27ae60",
                    "name": "Успех",
                    "slug": "success"
                },
                {
                    "color": "#f39c12",
                    "name": "Предупреждение",
                    "slug": "warning"
                },
                {
                    "color": "#e74c3c",
                    "name": "Опасность",
                    "slug": "danger"
                },
                {
                    "color": "#ecf0f1",
                    "name": "Светлый",
                    "slug": "light"
                },
                {
                    "color": "#34495e",
                    "name": "Темный",
                    "slug": "dark"
                },
                {
                    "color": "#ffffff",
                    "name": "Белый",
                    "slug": "white"
                },
                {
                    "color": "#000000",
                    "name": "Черный",
                    "slug": "black"
                }
            ],
            "gradients": [
                {
                    "gradient": "linear-gradient(135deg, #3498db 0%, #2c3e50 100%)",
                    "name": "Основной градиент",
                    "slug": "primary-gradient"
                },
                {
                    "gradient": "linear-gradient(135deg, #27ae60 0%, #3498db 100%)",
                    "name": "Акцентный градиент",
                    "slug": "accent-gradient"
                },
                {
                    "gradient": "linear-gradient(135deg, #ecf0f1 0%, #ffffff 100%)",
                    "name": "Светлый градиент",
                    "slug": "light-gradient"
                }
            ],
            "duotone": [
                {
                    "colors": ["#2c3e50", "#3498db"],
                    "slug": "primary-duotone",
                    "name": "Основной дуотон"
                },
                {
                    "colors": ["#27ae60", "#ecf0f1"],
                    "slug": "success-duotone",
                    "name": "Успешный дуотон"
                }
            ]
        },
        "typography": {
            "fontFamilies": [
                {
                    "fontFamily": "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif",
                    "name": "Системный",
                    "slug": "system"
                },
                {
                    "fontFamily": "Georgia, serif",
                    "name": "Serif",
                    "slug": "serif"
                },
                {
                    "fontFamily": "Monaco, Consolas, 'Andale Mono', 'DejaVu Sans Mono', monospace",
                    "name": "Monospace",
                    "slug": "monospace"
                }
            ],
            "fontSizes": [
                {
                    "size": "0.75rem",
                    "slug": "x-small",
                    "name": "Очень маленький"
                },
                {
                    "size": "0.875rem",
                    "slug": "small",
                    "name": "Маленький"
                },
                {
                    "size": "1rem",
                    "slug": "medium",
                    "name": "Средний"
                },
                {
                    "size": "1.125rem",
                    "slug": "large",
                    "name": "Большой"
                },
                {
                    "size": "1.25rem",
                    "slug": "x-large",
                    "name": "Очень большой"
                },
                {
                    "size": "1.5rem",
                    "slug": "xx-large",
                    "name": "Огромный"
                },
                {
                    "size": "2rem",
                    "slug": "xxx-large",
                    "name": "Гигантский"
                }
            ],
            "lineHeight": true,
            "letterSpacing": true,
            "textDecoration": true,
            "textTransform": true,
            "fontStyle": true,
            "fontWeight": true
        },
        "spacing": {
            "padding": true,
            "margin": true,
            "blockGap": true,
            "spacingScale": {
                "operator": "*",
                "increment": 1.5,
                "steps": 7,
                "mediumStep": 1.5,
                "unit": "rem"
            },
            "spacingSizes": [
                {
                    "size": "0.25rem",
                    "slug": "10",
                    "name": "XS"
                },
                {
                    "size": "0.5rem",
                    "slug": "20",
                    "name": "S"
                },
                {
                    "size": "1rem",
                    "slug": "30",
                    "name": "M"
                },
                {
                    "size": "1.5rem",
                    "slug": "40",
                    "name": "L"
                },
                {
                    "size": "2rem",
                    "slug": "50",
                    "name": "XL"
                },
                {
                    "size": "3rem",
                    "slug": "60",
                    "name": "XXL"
                }
            ]
        },
        "layout": {
            "contentSize": "1200px",
            "wideSize": "1400px"
        },
        "border": {
            "radius": true,
            "color": true,
            "style": true,
            "width": true
        },
        "shadow": {
            "presets": [
                {
                    "name": "Естественная",
                    "slug": "natural",
                    "shadow": "0 2px 4px rgba(0,0,0,0.1)"
                },
                {
                    "name": "Глубокая",
                    "slug": "deep",
                    "shadow": "0 8px 24px rgba(0,0,0,0.15)"
                },
                {
                    "name": "Резкая",
                    "slug": "sharp",
                    "shadow": "0 4px 0 #2c3e50"
                }
            ]
        },
        "dimensions": {
            "minHeight": true
        },
        "position": {
            "sticky": true
        },
        "custom": {
            "spacing": {
                "small": "max(1.25rem, 5vw)",
                "medium": "clamp(2rem, 8vw, calc(8 * var(--wp--preset--spacing--40)))",
                "large": "clamp(4rem, 10vw, 8rem)",
                "outer": "var(--wp--preset--spacing--30, 1rem)"
            },
            "typography": {
                "font-size": {
                    "huge": "clamp(2.25rem, 4vw, 2.75rem)",
                    "gigantic": "clamp(2.75rem, 6vw, 3.25rem)",
                    "colossal": "clamp(3.25rem, 8vw, 6.25rem)"
                },
                "line-height": {
                    "tiny": 1.15,
                    "small": 1.2,
                    "medium": 1.4,
                    "normal": 1.6
                }
            }
        }
    },
    "styles": {
        "color": {
            "background": "var(--wp--preset--color--white)",
            "text": "var(--wp--preset--color--black)"
        },
        "typography": {
            "fontFamily": "var(--wp--preset--font-family--system)",
            "lineHeight": "var(--wp--custom--typography--line-height--normal)",
            "fontSize": "var(--wp--preset--font-size--medium)"
        },
        "spacing": {
            "blockGap": "var(--wp--preset--spacing--30)"
        },
        "elements": {
            "h1": {
                "typography": {
                    "fontWeight": "600",
                    "lineHeight": "var(--wp--custom--typography--line-height--small)",
                    "fontSize": "var(--wp--custom--typography--font-size--colossal)"
                },
                "color": {
                    "text": "var(--wp--preset--color--primary)"
                }
            },
            "h2": {
                "typography": {
                    "fontWeight": "600",
                    "lineHeight": "var(--wp--custom--typography--line-height--small)",
                    "fontSize": "var(--wp--custom--typography--font-size--gigantic)"
                },
                "color": {
                    "text": "var(--wp--preset--color--primary)"
                }
            },
            "h3": {
                "typography": {
                    "fontWeight": "600",
                    "lineHeight": "var(--wp--custom--typography--line-height--small)",
                    "fontSize": "var(--wp--custom--typography--font-size--huge)"
                },
                "color": {
                    "text": "var(--wp--preset--color--primary)"
                }
            },
            "h4": {
                "typography": {
                    "fontWeight": "600",
                    "lineHeight": "var(--wp--custom--typography--line-height--small)",
                    "fontSize": "var(--wp--preset--font-size--xx-large)"
                },
                "color": {
                    "text": "var(--wp--preset--color--primary)"
                }
            },
            "h5": {
                "typography": {
                    "fontWeight": "600",
                    "lineHeight": "var(--wp--custom--typography--line-height--small)",
                    "fontSize": "var(--wp--preset--font-size--x-large)"
                },
                "color": {
                    "text": "var(--wp--preset--color--primary)"
                }
            },
            "h6": {
                "typography": {
                    "fontWeight": "600",
                    "lineHeight": "var(--wp--custom--typography--line-height--small)",
                    "fontSize": "var(--wp--preset--font-size--large)"
                },
                "color": {
                    "text": "var(--wp--preset--color--primary)"
                }
            },
            "link": {
                "color": {
                    "text": "var(--wp--preset--color--accent)"
                },
                ":hover": {
                    "color": {
                        "text": "var(--wp--preset--color--primary)"
                    },
                    "typography": {
                        "textDecoration": "underline"
                    }
                },
                ":focus": {
                    "color": {
                        "text": "var(--wp--preset--color--primary)"
                    },
                    "typography": {
                        "textDecoration": "underline"
                    }
                }
            },
            "button": {
                "color": {
                    "background": "var(--wp--preset--color--accent)",
                    "text": "var(--wp--preset--color--white)"
                },
                "border": {
                    "radiu