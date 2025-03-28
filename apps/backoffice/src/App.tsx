import { AuthProvider } from "./lib/context/AuthContext";
import { RouterWithAuth } from "./lib/router";

function App() {
  return (
    <AuthProvider>
      <RouterWithAuth />
    </AuthProvider>
  );
}

export default App;
