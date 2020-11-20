export class AccountNotVerified extends Error {
  constructor(message: string) {
    super(message)
    this.name = 'AccountNotVerified'
  }
}
