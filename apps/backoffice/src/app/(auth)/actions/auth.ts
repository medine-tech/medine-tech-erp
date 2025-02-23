import NextAuth from "next-auth";
import Credentials from "next-auth/providers/credentials";

export const {
	auth,
	signIn,
	signOut,
	handlers: { GET, POST },
} = NextAuth({
	pages: {
		signIn: "/login",
	},
	callbacks: {
		async jwt({ token, user }) {
			console.log("jwt");
			if (user) {
				console.log("inside 1");
				token.id = user.id;
				token.token = user.token;
			}

			return token;
		},
		async session({ session, token }) {
			console.log("session");
			if (token) {
				console.log("inside 2");
				session.user = {
					id: token.id,
					token: token.token,
				};
			}

			// Return the session object so it can be used by downstream code.
			return session;
		},
	},
	providers: [
		Credentials({
			name: "credentials",
			credentials: {
				email: { label: "Correo electrónico", type: "email" },
				password: { label: "Contraseña", type: "password" },
			},
			async authorize(credentials) {
				console.log(credentials, "credentials0");
				if (!credentials) {
					return null;
				}

				console.log(credentials, "credentials");
				const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/login`, {
					method: "POST",
					headers: {
						accept: "application/json",
						"Content-Type": "application/json",
					},
					body: JSON.stringify(credentials),
				});

				if (!response.ok) {
					return null;
				}

				const data = await response.json();

				console.log(data, "data");

				return {
					id: data.token,
					token: data.token,
				};
			},
		}),
	],
});
