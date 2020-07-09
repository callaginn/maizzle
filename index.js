const Maizzle = require('@maizzle/framework')

// Our script needs to follow these steps:
// 1. Convert custom syntax via php
// 2. Send to this script via shell_exec as a string
// 3. Print result to screen

var args = process.argv.slice(2),
	str = args[0];

Maizzle.render(
  str,
  {
    tailwind: {
      config: require('./tailwind.config'),
      css: `
        @tailwind utilities;
        .button { @apply rounded text-center bg-green-500 text-white; }
        .button:hover { @apply bg-blue-700; }
        .button a { @apply inline-block py-16 px-24 text-sm font-semibold no-underline text-white; }
      `,
    },
    maizzle: {
      config: require('./config'),
    }
  }
).then(html => console.log(html)).catch(error => console.log(error));
