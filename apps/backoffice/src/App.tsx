import { useState } from 'react'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"

function App() {
  const [count, setCount] = useState(0)

  return (
    <div className="min-h-screen bg-background flex items-center justify-center p-4">
      <div className="max-w-md w-full space-y-6">
        <div className="text-center space-y-2">
          <h1 className="text-3xl font-bold">Medine Tech Backoffice</h1>
          <p className="text-muted-foreground">React 19 + shadcn/ui + Tailwind 4</p>
        </div>

        <Card>
          <CardHeader>
            <CardTitle>Welcome to Backoffice</CardTitle>
            <CardDescription>
              A modern admin dashboard built with the latest technologies
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              <div className="flex justify-center">
                <Button 
                  size="lg" 
                  className="w-full max-w-xs" 
                  onClick={() => setCount((count) => count + 1)}
                >
                  Count is {count}
                </Button>
              </div>
              <p className="text-sm text-center text-muted-foreground">
                Edit <code className="bg-muted p-1 rounded-sm">src/App.tsx</code> to customize this page
              </p>
            </div>
          </CardContent>
          <CardFooter className="flex justify-between">
            <Button variant="outline">Cancel</Button>
            <Button>Continue</Button>
          </CardFooter>
        </Card>
      </div>
    </div>
  )
}

export default App
